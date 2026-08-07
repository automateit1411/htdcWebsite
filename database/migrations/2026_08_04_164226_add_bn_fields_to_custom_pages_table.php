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
        Schema::table('custom_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('custom_pages', 'page_name_bn')) {
                $table->string('page_name_bn')->nullable()->after('page_name');
            }
            if (!Schema::hasColumn('custom_pages', 'category_bn')) {
                $table->string('category_bn')->nullable()->after('category');
            }
            if (!Schema::hasColumn('custom_pages', 'subcategory_bn')) {
                $table->string('subcategory_bn')->nullable()->after('subcategory');
            }
            if (!Schema::hasColumn('custom_pages', 'title_bn')) {
                $table->string('title_bn')->nullable()->after('title');
            }
            if (!Schema::hasColumn('custom_pages', 'description_bn')) {
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
        Schema::table('custom_pages', function (Blueprint $table) {
            $table->dropColumn(['page_name_bn', 'category_bn', 'subcategory_bn', 'title_bn', 'description_bn']);
        });
    }
};
