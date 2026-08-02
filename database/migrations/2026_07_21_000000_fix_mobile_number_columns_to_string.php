<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('sMobileNo')->nullable()->change();
            $table->string('fMobileNo')->nullable()->change();
            $table->string('mMobileNo')->nullable()->change();
            $table->string('gMobileNo')->nullable()->change();
            $table->string('refMobileNo')->nullable()->change();
        });

        Schema::table('teacher_applications', function (Blueprint $table) {
            $table->string('mobile')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->bigInteger('sMobileNo')->nullable()->change();
            $table->bigInteger('fMobileNo')->nullable()->change();
            $table->bigInteger('mMobileNo')->nullable()->change();
            $table->bigInteger('gMobileNo')->nullable()->change();
            $table->bigInteger('refMobileNo')->nullable()->change();
        });

        Schema::table('teacher_applications', function (Blueprint $table) {
            $table->bigInteger('mobile')->nullable()->change();
        });
    }
};
