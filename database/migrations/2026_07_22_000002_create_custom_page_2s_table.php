<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('custom_page_2s', function (Blueprint $table) {
            $table->id();
            $table->string('page_name');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('route')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('custom_page_2_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_page_2_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('custom_page_2_items');
        Schema::dropIfExists('custom_page_2s');
    }
};
