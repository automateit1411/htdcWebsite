<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class DatabaseExportController extends Controller
{
    private function getColumnNames($tableName)
    {
        $columns = DB::select("SHOW COLUMNS FROM `{$tableName}`");
        return array_map(fn($c) => $c->Field, $columns);
    }

    private function getMediaFolders()
    {
        $storagePath = public_path('storage');
        $folders = [];

        if (!is_dir($storagePath)) {
            return $folders;
        }

        $dirs = glob($storagePath . '/*', GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            $folderName = basename($dir);
            $files = glob($dir . '/*');
            $totalSize = 0;
            foreach ($files as $file) {
                if (is_file($file)) {
                    $totalSize += filesize($file);
                }
            }
            $folders[] = [
                'name' => $folderName,
                'file_count' => count($files),
                'total_size' => $totalSize,
                'path' => $dir,
            ];
        }

        return $folders;
    }

    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function index()
    {
        $dbName = config('database.connections.mysql.database');
        $tables = DB::select("SHOW TABLES");
        $tableKey = "Tables_in_{$dbName}";

        $tableList = [];
        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            $rowCount = DB::table($tableName)->count();
            $columns = DB::select("SHOW COLUMNS FROM `{$tableName}`");
            $tableList[] = [
                'name' => $tableName,
                'rows' => $rowCount,
                'column_count' => count($columns),
            ];
        }

        $mediaFolders = $this->getMediaFolders();
        foreach ($mediaFolders as &$folder) {
            $folder['total_size_formatted'] = $this->formatSize($folder['total_size']);
        }

        return view('admin.database-export.index', compact('tableList', 'dbName', 'mediaFolders'));
    }

    public function download($table)
    {
        $dbName = config('database.connections.mysql.database');
        $tables = DB::select("SHOW TABLES");
        $tableKey = "Tables_in_{$dbName}";
        $validTables = array_map(fn($t) => $t->$tableKey, $tables);

        if (!in_array($table, $validTables)) {
            abort(404, 'Table not found.');
        }

        $columnNames = $this->getColumnNames($table);
        $rows = DB::table($table)->get();

        $filename = $table . '_' . now()->format('Y-m-d_H-i-s') . '.sql';

        $sql = "-- Database: {$dbName}\n";
        $sql .= "-- Table: {$table}\n";
        $sql .= "-- Exported: " . now()->format('Y-m-d H:i:s') . "\n\n";

        foreach ($rows as $row) {
            $rowData = get_object_vars($row);
            $values = [];
            foreach ($columnNames as $col) {
                $val = $rowData[$col] ?? null;
                if ($val === null) {
                    $values[] = 'NULL';
                } elseif (is_numeric($val)) {
                    $values[] = $val;
                } else {
                    $values[] = "'" . addslashes($val) . "'";
                }
            }
            $sql .= "INSERT INTO `{$table}` (`" . implode('`, `', $columnNames) . "`) VALUES (" . implode(', ', $values) . ");\n";
        }

        return response($sql, 200, [
            'Content-Type' => 'text/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function downloadAll()
    {
        $dbName = config('database.connections.mysql.database');
        $tables = DB::select("SHOW TABLES");
        $tableKey = "Tables_in_{$dbName}";

        $zipFile = tempnam(sys_get_temp_dir(), 'db_export_') . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($tables as $tableObj) {
            $tableName = $tableObj->$tableKey;
            $columnNames = $this->getColumnNames($tableName);
            $rows = DB::table($tableName)->get();

            $sql = "-- Table: {$tableName}\n\n";
            foreach ($rows as $row) {
                $rowData = get_object_vars($row);
                $values = [];
                foreach ($columnNames as $col) {
                    $val = $rowData[$col] ?? null;
                    if ($val === null) {
                        $values[] = 'NULL';
                    } elseif (is_numeric($val)) {
                        $values[] = $val;
                    } else {
                        $values[] = "'" . addslashes($val) . "'";
                    }
                }
                $sql .= "INSERT INTO `{$tableName}` (`" . implode('`, `', $columnNames) . "`) VALUES (" . implode(', ', $values) . ");\n";
            }

            $zip->addFromString($tableName . '.sql', $sql);
        }

        $zip->close();

        $downloadName = 'database_export_' . now()->format('Y-m-d_H-i-s') . '.zip';

        return response()->download($zipFile, $downloadName)->deleteFileAfterSend(true);
    }

    public function downloadMedia($folder = null)
    {
        $storagePath = public_path('storage');

        if (!is_dir($storagePath)) {
            abort(404, 'Storage folder not found.');
        }

        if ($folder) {
            $targetPath = $storagePath . '/' . $folder;
            if (!is_dir($targetPath)) {
                abort(404, 'Folder not found.');
            }
        } else {
            $targetPath = $storagePath;
        }

        $zipFile = tempnam(sys_get_temp_dir(), 'media_backup_') . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->addDirectoryToZip($zip, $targetPath, $folder ? $folder : 'storage');

        $zip->close();

        $downloadName = ($folder ? $folder : 'storage') . '_backup_' . now()->format('Y-m-d_H-i-s') . '.zip';

        return response()->download($zipFile, $downloadName)->deleteFileAfterSend(true);
    }

    private function addDirectoryToZip(ZipArchive $zip, $directory, $zipPath)
    {
        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === '.gitignore') {
                continue;
            }

            $filePath = $directory . '\\' . $file;
            $zipFilePath = $zipPath . '/' . $file;

            if (is_file($filePath)) {
                $zip->addFile($filePath, $zipFilePath);
            } elseif (is_dir($filePath)) {
                $this->addDirectoryToZip($zip, $filePath, $zipFilePath);
            }
        }
    }

    public function downloadAllMedia()
    {
        $storagePath = public_path('storage');

        if (!is_dir($storagePath)) {
            abort(404, 'Storage folder not found.');
        }

        $zipFile = tempnam(sys_get_temp_dir(), 'media_backup_') . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->addDirectoryToZip($zip, $storagePath, 'storage');

        $zip->close();

        $downloadName = 'all_media_backup_' . now()->format('Y-m-d_H-i-s') . '.zip';

        return response()->download($zipFile, $downloadName)->deleteFileAfterSend(true);
    }
}
