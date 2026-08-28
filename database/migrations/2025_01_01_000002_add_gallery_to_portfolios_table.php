<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * افزودن گالری تصاویر به نمونه‌کارها:
 * هر پروژه می‌تواند چندین تصویر داشته باشد که در مودال جزئیات
 * به‌صورت گالری تعاملی (اسلاید اصلی + بندانگشتی‌ها + لایت‌باکس) نمایش داده می‌شوند.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->json('gallery_paths')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn('gallery_paths');
        });
    }
};
