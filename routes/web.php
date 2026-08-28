<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| روت‌های سایت رزومه
|--------------------------------------------------------------------------
| فرانت:    /{locale}          => fa / en
| پنل:      /admin             => نیازمند ورود (Breeze)
| ورود:     /login             => ویو لاگین Breeze
*/

// ───────────────────────── روت اصلی → زبان پیش‌فرض ─────────────────────────
Route::get('/', fn () => redirect()->route('home', ['locale' => 'fa']));

// ────────────────────────────── تغییر زبان ─────────────────────────────────
Route::get('/lang/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['fa', 'en']), 400);

    session(['locale' => $locale]);

    // زبان را داخل URL قبلی جابه‌جا می‌کنیم تا کاربر در همان صفحه بماند
    $path = parse_url(url()->previous(), PHP_URL_PATH) ?: '/fa';
    $segments = explode('/', trim($path, '/'));

    if (isset($segments[0]) && in_array($segments[0], ['fa', 'en'], true)) {
        $segments[0] = $locale;
    } else {
        array_unshift($segments, $locale);
    }

    return redirect('/' . implode('/', $segments));
})->name('lang.switch');

// ───────────────────────────── فرانت (دوزبانه) ─────────────────────────────
Route::prefix('{locale}')
    ->whereIn('locale', ['fa', 'en'])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        // محدودیت ضد اسپم: حداکثر ۱۰ ارسال فرم در دقیقه برای هر IP
        Route::post('/contact', [ContactController::class, 'store'])
            ->middleware('throttle:10,1')
            ->name('contact.store');
    });

// ───────────────────────────── پنل مدیریت (Admin) ──────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // اطلاعات شخصی (تک رکورد)
        Route::get('personal-info', [Admin\PersonalInfoController::class, 'edit'])->name('personal-info.edit');
        Route::put('personal-info', [Admin\PersonalInfoController::class, 'update'])->name('personal-info.update');

        // تجربه‌های کاری
        Route::resource('experiences', Admin\ExperienceController::class)->except(['show']);

        // تحصیلات
        Route::resource('educations', Admin\EducationController::class)->except(['show']);

        // مهارت‌ها
        Route::resource('skills', Admin\SkillController::class)->except(['show']);

        // نمونه‌کارها
        Route::resource('portfolios', Admin\PortfolioController::class)->except(['show']);

        // نظرات کارفرماها
        Route::resource('testimonials', Admin\TestimonialController::class)->except(['show']);

        // لینک‌های شبکه‌های اجتماعی
        Route::resource('social-links', Admin\SocialLinkController::class)->except(['show']);

        // پیام‌های فرم تماس
        Route::get('messages', [Admin\MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [Admin\MessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');

        // تنظیمات سایت
        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    });

// ───────────────────── روت‌های Auth (Breeze) را نگه دارید ──────────────────
//require __DIR__ . '/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
