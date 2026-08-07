<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teacher_applications', function (Blueprint $table) {
            // Drop unwanted columns
            $table->dropColumn([
                'designation',
                'indexNo',
                'ein',
                'appointmentType',
                'bankName',
                'bankAccountNo',
            ]);
        });

        Schema::table('teacher_applications', function (Blueprint $table) {
            // Add document columns for each education level
            $table->string('sscCertificateScan')->nullable()->after('sscMarksheetScan');
            $table->string('hscCertificateScan')->nullable()->after('hscMarksheetScan');
            $table->string('graduationCertificateScan')->nullable()->after('graduationMarksheetScan');
        });
    }

    public function down(): void
    {
        Schema::table('teacher_applications', function (Blueprint $table) {
            $table->string('designation')->nullable();
            $table->string('indexNo')->nullable();
            $table->string('ein')->nullable();
            $table->string('appointmentType')->nullable();
            $table->string('bankName')->nullable();
            $table->bigInteger('bankAccountNo')->nullable();
        });

        Schema::table('teacher_applications', function (Blueprint $table) {
            $table->dropColumn([
                'sscCertificateScan',
                'hscCertificateScan',
                'graduationCertificateScan',
            ]);
        });
    }
};
