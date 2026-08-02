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
        if (!Schema::hasColumn('settings', 'about_image_id')) {
            Schema::table('settings', function (Blueprint $table) {
                // Create new about_image_id field to store gallery ID
                $table->unsignedBigInteger('about_image_id')->nullable()->after('about_description');
                
                // Add foreign key constraint
                $table->foreign('about_image_id')->references('id')->on('galleries')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Remove foreign key and column
            $table->dropForeign(['about_image_id']);
            $table->dropColumn('about_image_id');
        });
    }
};
