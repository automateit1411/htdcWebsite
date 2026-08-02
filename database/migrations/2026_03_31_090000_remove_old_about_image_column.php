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
        if (Schema::hasColumn('settings', 'about_image')) {
            Schema::table('settings', function (Blueprint $table) {
                // Remove the old about_image column (string type) as we now use about_image_id
                $table->dropColumn('about_image');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Add back the old column if rollback needed
            $table->string('about_image')->nullable()->after('about_description');
        });
    }
};
