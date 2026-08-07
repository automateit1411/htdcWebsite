<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Notices
        Schema::table('notices', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('content_bn')->nullable()->after('content');
        });

        // Galleries
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('description_bn')->nullable()->after('description');
        });

        // Sliders
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('description_bn')->nullable()->after('description');
        });

        // Form Downloads
        Schema::table('form_downloads', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('content_bn')->nullable()->after('content');
        });

        // Teacher Vacant Posts
        Schema::table('teacher_vacant_posts', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('content_bn')->nullable()->after('content');
        });

        // Staff Vacant Posts
        Schema::table('staff_vacant_posts', function (Blueprint $table) {
            $table->string('title_bn')->nullable()->after('title');
            $table->text('content_bn')->nullable()->after('content');
        });

        // Website Links
        Schema::table('website_links', function (Blueprint $table) {
            $table->string('name_bn')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('notices', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'content_bn']);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'description_bn']);
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'description_bn']);
        });

        Schema::table('form_downloads', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'content_bn']);
        });

        Schema::table('teacher_vacant_posts', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'content_bn']);
        });

        Schema::table('staff_vacant_posts', function (Blueprint $table) {
            $table->dropColumn(['title_bn', 'content_bn']);
        });

        Schema::table('website_links', function (Blueprint $table) {
            $table->dropColumn('name_bn');
        });
    }
};
