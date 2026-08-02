<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // BOU (Board of Trustees) fields
            if (!Schema::hasColumn('settings', 'bou_body')) {
                $table->string('bou_body')->nullable()->after('principal_image');
            }
            if (!Schema::hasColumn('settings', 'bou_description')) {
                $table->text('bou_description')->nullable()->after('bou_body');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'bou_body',
                'bou_description'
            ]);
        });
    }
};
