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
        Schema::table('custom_page_2s', function (Blueprint $table) {
            if (!Schema::hasColumn('custom_page_2s', 'page_name_bn')) {
                $table->string('page_name_bn')->nullable()->after('page_name');
            }
            if (!Schema::hasColumn('custom_page_2s', 'title_bn')) {
                $table->string('title_bn')->nullable()->after('title');
            }
            if (!Schema::hasColumn('custom_page_2s', 'description_bn')) {
                $table->text('description_bn')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_page_2s', function (Blueprint $table) {
            $table->dropColumn(['page_name_bn', 'title_bn', 'description_bn']);
        });
    }
};
