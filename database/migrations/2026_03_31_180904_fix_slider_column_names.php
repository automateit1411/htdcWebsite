<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            // Add description column if it doesn't exist
            if (!Schema::hasColumn('sliders', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            
            // Rename 'active' to 'is_active' for MariaDB compatibility
            if (Schema::hasColumn('sliders', 'active') && !Schema::hasColumn('sliders', 'is_active')) {
                // First add the new column
                $table->boolean('is_active')->default(true)->after('order');
            }
        });
        
        // Copy data outside the schema closure
        if (Schema::hasColumn('sliders', 'active') && Schema::hasColumn('sliders', 'is_active')) {
            DB::statement('UPDATE sliders SET is_active = active');
            
            // Then drop the old column in a separate operation
            Schema::table('sliders', function (Blueprint $table) {
                $table->dropColumn('active');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'is_active')) {
                $table->boolean('active')->default(true)->after('is_active');
            }
        });

        if (Schema::hasColumn('sliders', 'is_active') && Schema::hasColumn('sliders', 'active')) {
            DB::statement('UPDATE sliders SET active = is_active');
            
            Schema::table('sliders', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
