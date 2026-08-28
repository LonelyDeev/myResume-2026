# سایت رزومه شخصی — مهدی یوسفی (Laravel + Breeze)

سایت رزومه دوزبانه (فارسی/انگلیسی) با پنل مدیریت کامل — تمام محتوای سایت از پنل ادمین قابل کنترل است.

| مشخصه | مقدار |
|---|---|
| فرانت | تک‌صفحه‌ای (One-Page) — تم تیره پریمیوم — Tailwind CSS (CDN) |
| زبان‌ها | فارسی (پیش‌فرض، RTL) و انگلیسی (LTR) — با `/fa` و `/en` در URL |
| پنل ادمین | فارسی، RTL — داشبورد + CRUD کامل همه بخش‌ها |
| احراز هویت | Laravel Breeze (ویو لاگین سفارشی ارائه شده) |

---

## ۱) کپی کردن فایل‌ها در پروژه لاراول

فایل‌های این پکیج را مطابق ساختار زیر داخل پروژه لاراول خود کپی کنید (فقط کافیست محتوای پوشه‌ها را merge کنید):

```
app/
 ├── Http/
 │   ├── Controllers/
 │   │   ├── Admin/            ← ۱۰ کنترلر پنل مدیریت
 │   │   ├── Front/            ← HomeController و ContactController
 │   │   └── Concerns/UploadsMedia.php
 │   └── Middleware/SetLocale.php
 ├── Models/
 │   ├── Concerns/HasTranslations.php
 │   ├── PersonalInfo.php  Experience.php  Education.php  Skill.php
 │   ├── Portfolio.php  Testimonial.php  SocialLink.php
 │   └── Message.php  Setting.php

database/
 ├── migrations/2025_01_01_000001_create_resume_tables.php   ← هر ۹ جدول در یک فایل
 └── seeders/
     ├── DatabaseSeeder.php   (جایگزین فایل فعلی شود)
     ├── ResumeSeeder.php
     └── files/Mahdi_Yousefi_Resume_FA.pdf   ← اگر خواستید رزومه PDF به‌صورت خودکار منتشر شود

lang/
 ├── fa/app.php
 └── en/app.php

resources/views/
 ├── layouts/
 │   ├── app.blade.php          ← لایوت فرانت (تیره پریمیوم)
 │   ├── admin.blade.php        ← لایوت پنل مدیریت
 │   └── guest-lite.blade.php   ← لایوت صفحات Auth
 ├── front/
 │   ├── home.blade.php
 │   └── partials/ (hero, about, experience, education, skills, portfolios, testimonials, contact)
 ├── admin/
 │   ├── dashboard.blade.php
 │   ├── personal-info/edit.blade.php
 │   ├── experiences/ (index + form)
 │   ├── educations/ (index + form)
 │   ├── skills/ (index + form)
 │   ├── portfolios/ (index + form)
 │   ├── testimonials/ (index + form)
 │   ├── social-links/ (index + form)
 │   ├── messages/ (index + show)
 │   └── settings/edit.blade.php
 └── auth/login.blade.php       ← جایگزین ویو لاگین Breeze شود

routes/web.php                   ← جایگزین فایل فعلی شود (خط require auth.php در انتهای آن حفظ شده)
README.md
```

> ⚠️ اگر روت یا ویوی سفارشی دیگری در `routes/web.php` و ویوهای Breeze دارید، قبل از جایگزینی نسخه پشتیبان بگیرید.

## ۲) ثبت Middleware زبان (فقط Laravel 11 به بالا)

در فایل `bootstrap/app.php` این تغییر را بدهید:

```php
<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'setlocale' => SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
```

> اگر روی Laravel 10 هستید، به‌جای آن Alias را در `app/Http/Kernel.php` داخل `$middlewareAliases` ثبت کنید.

## ۳) زبان پیش‌فرض اپلیکیشن

در فایل `.env` پروژه:

```env
APP_LOCALE=fa
APP_FALLBACK_LOCALE=en
```

## ۴) نصب و اجرا

```bash
# مایگریشن جداول + سیدر محتوای رزومه + کاربر ادمین
php artisan migrate --seed

# لینک پوشه storage برای نمایش تصاویر و فایل رزومه (الزامی)
php artisan storage:link

# اجرا
php artisan serve
```

| مسیر | توضیح |
|---|---|
| `/` | ریدایرکت به `/fa` |
| `/fa` | سایت فارسی |
| `/en` | سایت انگلیسی |
| `/login` | ورود به پنل |
| `/admin` | داشبورد مدیریت (نیازمند ورود) |

## ۵) اطلاعات ورود پیش‌فرض

```
ایمیل: admin@example.com
رمز:   password
```

> ⚠️ بلافاصله بعد از اولین ورود، رمز را تغییر دهید (یا در `database/seeders/DatabaseSeeder.php` مقدار آن را قبل از seed عوض کنید).

## ۶) امکانات پنل مدیریت

- **اطلاعات شخصی:** نام، عنوان شغلی (با افکت تایپ چندعنوانی)، بیوگرافی، توانمندی‌ها، راه‌های تماس، آپلود تصویر پروفایل و فایل PDF رزومه
- **تجربه‌های کاری:** با بازه زمانی، نشان «شغل فعلی» و بولت‌های وظایف (هر خط = یک بولت)
- **تحصیلات و دوره‌ها:** دانشگاه/مؤسسه، بازه زمانی
- **مهارت‌ها:** گروه‌بندی با «دسته» — اگر «سطح» پر شود نوار پیشرفت وگرنه تگ نمایش داده می‌شود
- **نمونه‌کارها:** دسته‌بندی (سازنده فیلتر صفحه اصلی)، کارفرما، لینک، تگ تکنولوژی، آپلود تصویر اختیاری (بدون تصویر = کارت گرادیانی با حرف اول)، نشان «پروژه شاخص»
- **نظرات کارفرماها:** با تصویر اختیاری
- **شبکه‌های اجتماعی:** هر لینک با آیکون Font Awesome
- **پیام‌ها:** صندوق ورودی فرم تماس با شمارنده خوانده‌نشده در سایدبار + پاسخ سریع با mailto
- **تنظیمات سایت:** عنوان و متا دوزبانه، متن فوتر، متن سکشن تماس، و **کلیدهای روشن/خاموش نمایش هر سکشن** (سکشن غیرفعال از صفحه اصلی و منو حذف می‌شود)

## ۷) ساختار دوزبانه بودن

- ستون‌های اصلی جدول = محتوای **فارسی**؛ ستون‌های `*_en` = محتوای **انگلیسی**
- تریت `App\Models\Concerns\HasTranslations` متد `t('field')` را فراهم می‌کند: مقدار زبان جاری را برمی‌گرداند و اگر خالی بود به فارسی fallback می‌کند
- متن‌های ثابت رابط کاربری در `lang/fa/app.php` و `lang/en/app.php`
- تغییر زبان با لینک گِرد (FA/EN) در هدر؛ کاربر در همان صفحه‌ای که هست می‌ماند

## ۸) نکات فنی

- فرم تماس با throttle محافظت شده (۱۰ پیام در دقیقه برای هر IP) و پیام‌ها در جدول `messages` ذخیره می‌شوند
- آپلودها در `storage/app/public` (پوشه‌های `avatar`، `cv`، `portfolios`، `testimonials`) ذخیره می‌شوند؛ حتماً `php artisan storage:link` را اجرا کنید
- نظرات سیدرشده **نمونه** هستند — از پنل با نظرات واقعی جایگزین کنید
- برای ارتقای CSS از CDN به Vite: کلاس‌ها استاندارد Tailwind هستند و کافیست Tailwind را با `npm` نصب و کلاس‌ها را به `resources/css/app.css` منتقل کنید
- انیمیشن‌ها: AOS (اسکرول)، تایپ متنی، شمارنده نوار مهارت‌ها، اسکرول‌اسپای منو
