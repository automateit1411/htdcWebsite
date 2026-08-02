<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('program_group_id')->constrained('program_groups')->onDelete('cascade');
            $table->integer('total_students')->default(0);
            $table->integer('present_students')->default(0);
            $table->integer('absent_students')->default(0);
            $table->decimal('percentage', 5, 2)->default(0);
            $table->timestamps();

            $table->unique(['date', 'program_group_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_attendances');
    }
};
