<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ساخت تمام جداول سیستم رزومه:
 *
 *   personal_infos   => اطلاعات شخصی (تک رکورد)
 *   experiences      => تجربه‌های کاری
 *   educations       => تحصیلات و دوره‌ها
 *   skills           => مهارت‌ها (دسته‌بندی‌شده + نوار سطح اختیاری)
 *   portfolios       => نمونه‌کارها
 *   testimonials     => نظرات کارفرماها
 *   social_links     => لینک‌های شبکه‌های اجتماعی
 *   messages         => پیام‌های فرم تماس
 *   settings         => تنظیمات سایت (تک رکورد)
 *
 * نکته دوزبانه: ستون‌های اصلی محتوای فارسی و ستون‌های _en محتوای انگلیسی هستند.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ─────────────────────────── اطلاعات شخصی ───────────────────────────
        Schema::create('personal_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_title_en')->nullable();
            $table->string('tagline')->nullable();
            $table->string('tagline_en')->nullable();
            $table->longText('bio')->nullable();
            $table->longText('bio_en')->nullable();
            $table->text('abilities')->nullable();          // هر خط = یک توانمندی
            $table->text('abilities_en')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('secondary_phone', 32)->nullable();
            $table->string('website')->nullable();
            $table->string('telegram')->nullable();          // آیدی تلگرام بدون @
            $table->string('birth_date', 100)->nullable();
            $table->string('birth_date_en', 100)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('city_en', 150)->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('cv_path')->nullable();           // فایل PDF رزومه
            $table->timestamps();
        });

        // ─────────────────────────── تجربه‌های کاری ──────────────────────────
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('position_en')->nullable();
            $table->string('company');
            $table->string('company_en')->nullable();
            $table->string('period', 150);                   // مثال: خرداد ۱۴۰۳ — اسفند ۱۴۰۴
            $table->string('period_en', 150)->nullable();
            $table->boolean('is_current')->default(false);   // شغل فعلی
            $table->text('description')->nullable();         // هر خط = یک بولت
            $table->text('description_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ───────────────────────────── تحصیلات ──────────────────────────────
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('degree');
            $table->string('degree_en')->nullable();
            $table->string('institution');
            $table->string('institution_en')->nullable();
            $table->string('period', 150)->nullable();
            $table->string('period_en', 150)->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ───────────────────────────── مهارت‌ها ─────────────────────────────
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('category');                      // مثال: Backend & CMS
            $table->string('category_en')->nullable();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->unsignedTinyInteger('level')->nullable(); // 0..100 — خالی = نمایش به‌صورت تگ
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ──────────────────────────── نمونه‌کارها ───────────────────────────
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('category')->nullable();          // برای فیلتر
            $table->string('category_en')->nullable();
            $table->string('client')->nullable();
            $table->string('client_en')->nullable();
            $table->string('url')->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_en')->nullable();
            $table->string('tech_tags')->nullable();         // با کاما جدا شود
            $table->string('image_path')->nullable();        // تصویر اختیاری
            $table->boolean('is_featured')->default(false);  // پروژه شاخص
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ───────────────────────── نظرات کارفرماها ──────────────────────────
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->string('position')->nullable();
            $table->string('position_en')->nullable();
            $table->text('content');
            $table->text('content_en')->nullable();
            $table->string('avatar_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ─────────────────────── لینک‌های شبکه‌های اجتماعی ───────────────────
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 100);
            $table->string('url', 500);
            $table->string('icon', 100)->nullable();         // کلاس Font Awesome
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ─────────────────────── پیام‌های فرم تماس ───────────────────────────
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // ───────────────────────── تنظیمات سایت ─────────────────────────────
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->default('رزومه من');
            $table->string('site_title_en')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_description_en')->nullable();
            $table->string('footer_text')->nullable();
            $table->string('footer_text_en')->nullable();
            $table->text('contact_intro')->nullable();
            $table->text('contact_intro_en')->nullable();
            $table->boolean('show_about')->default(true);
            $table->boolean('show_experience')->default(true);
            $table->boolean('show_education')->default(true);
            $table->boolean('show_skills')->default(true);
            $table->boolean('show_portfolios')->default(true);
            $table->boolean('show_testimonials')->default(true);
            $table->boolean('show_contact')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('educations');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('personal_infos');
    }
};
