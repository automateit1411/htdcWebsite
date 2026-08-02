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
            // Founder fields
            if (!Schema::hasColumn('settings', 'founder_name')) {
                $table->string('founder_name')->nullable()->after('about_image_id');
            }
            if (!Schema::hasColumn('settings', 'founder_title')) {
                $table->string('founder_title')->nullable()->after('founder_name');
            }
            if (!Schema::hasColumn('settings', 'founder_message')) {
                $table->text('founder_message')->nullable()->after('founder_title');
            }
            if (!Schema::hasColumn('settings', 'founder_image')) {
                $table->string('founder_image')->nullable()->after('founder_message');
            }
            
            // Principal fields
            if (!Schema::hasColumn('settings', 'principal_name')) {
                $table->string('principal_name')->nullable()->after('founder_image');
            }
            if (!Schema::hasColumn('settings', 'principal_title')) {
                $table->string('principal_title')->nullable()->after('principal_name');
            }
            if (!Schema::hasColumn('settings', 'principal_message')) {
                $table->text('principal_message')->nullable()->after('principal_title');
            }
            if (!Schema::hasColumn('settings', 'principal_image')) {
                $table->string('principal_image')->nullable()->after('principal_message');
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
                'founder_name',
                'founder_title',
                'founder_message',
                'founder_image',
                'principal_name',
                'principal_title',
                'principal_message',
                'principal_image'
            ]);
        });
    }
};
