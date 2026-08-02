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
            if (!Schema::hasColumn('settings', 'about_title')) {
                $table->string('about_title')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('settings', 'about_description')) {
                $table->text('about_description')->nullable()->after('about_title');
            }
            if (!Schema::hasColumn('settings', 'about_image')) {
                $table->string('about_image')->nullable()->after('about_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['about_title', 'about_description', 'about_image']);
        });
    }
};
