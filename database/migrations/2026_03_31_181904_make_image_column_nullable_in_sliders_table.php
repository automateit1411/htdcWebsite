<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            // Drop the existing image column
            $table->dropColumn('image');
        });
        
        Schema::table('sliders', function (Blueprint $table) {
            // Re-add it as nullable
            $table->string('image')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            // Drop the nullable image column
            $table->dropColumn('image');
        });
        
        Schema::table('sliders', function (Blueprint $table) {
            // Re-add it as not nullable (original state)
            $table->string('image')->after('id');
        });
    }
};
