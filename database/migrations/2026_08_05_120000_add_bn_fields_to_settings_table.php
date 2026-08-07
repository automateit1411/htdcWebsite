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
        Schema::table('settings', function (Blueprint $table) {
            // College Information Bangla fields
            $table->string('college_name_bn')->nullable()->after('college_name');
            $table->string('location_bn')->nullable()->after('location');
            $table->text('address_bn')->nullable()->after('address');
            
            // About Section Bangla fields
            $table->string('about_title_bn')->nullable()->after('about_title');
            $table->text('about_description_bn')->nullable()->after('about_description');
            
            // Founder Section Bangla fields
            $table->string('founder_name_bn')->nullable()->after('founder_name');
            $table->string('founder_title_bn')->nullable()->after('founder_title');
            $table->text('founder_message_bn')->nullable()->after('founder_message');
            
            // Principal Section Bangla fields
            $table->string('principal_name_bn')->nullable()->after('principal_name');
            $table->string('principal_title_bn')->nullable()->after('principal_title');
            $table->text('principal_message_bn')->nullable()->after('principal_message');
            
            // BOU Section Bangla fields
            $table->string('bou_body_bn')->nullable()->after('bou_body');
            $table->text('bou_description_bn')->nullable()->after('bou_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'college_name_bn',
                'location_bn',
                'address_bn',
                'about_title_bn',
                'about_description_bn',
                'founder_name_bn',
                'founder_title_bn',
                'founder_message_bn',
                'principal_name_bn',
                'principal_title_bn',
                'principal_message_bn',
                'bou_body_bn',
                'bou_description_bn',
            ]);
        });
    }
};
