<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('custom_page_2s', function (Blueprint $table) {
            $table->string('route')->nullable()->after('slug');
        });
    }

    public function down()
    {
        Schema::table('custom_page_2s', function (Blueprint $table) {
            $table->dropColumn('route');
        });
    }
};
