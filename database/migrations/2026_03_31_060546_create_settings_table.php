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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('college_name')->default('Hazera-Taju Degree College');
            $table->string('location')->default('Chandgaon, Chittagong');
            $table->string('telephone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('ein')->nullable();
            $table->string('nu_code')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->text('google_map_embed')->nullable();
            
            // About Fields
            $table->string('about_title')->nullable();
            $table->text('about_description')->nullable();
            $table->unsignedBigInteger('about_image_id')->nullable();
            $table->foreign('about_image_id')->references('id')->on('galleries')->onDelete('set null');
            
            // Founder Fields
            $table->string('founder_name')->nullable();
            $table->string('founder_title')->nullable();
            $table->text('founder_message')->nullable();
            $table->string('founder_image')->nullable();
            
            // Principal Fields
            $table->string('principal_name')->nullable();
            $table->string('principal_title')->nullable();
            $table->text('principal_message')->nullable();
            $table->string('principal_image')->nullable();
            
            // BOU Fields
            $table->string('bou_body')->nullable();
            $table->text('bou_description')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
