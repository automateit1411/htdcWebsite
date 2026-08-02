<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('program_groups', function (Blueprint $table) {
            $table->id();
            $table->string('program'); // HSC, Honours, Degree
            $table->string('group_name'); // Science, Business, Humanities, BBA, BSA, BSS, Accounting, Management, Economics
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('program_groups');
    }
};
