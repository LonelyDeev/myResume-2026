<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\PersonalInfo;
use App\Models\Portfolio;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * سیدر محتوای رزومه — بر اساس رزومه واقعی مهدی یوسفی
 * تمام داده‌ها بعداً از پنل مدیریت قابل ویرایش هستند.
 */
class ResumeSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPersonalInfo();
        $this->seedExperiences();
        $this->seedEducations();
        $this->seedSkills();
        $this->seedPortfolios();
        $this->seedTestimonials();
        $this->seedSocialLinks();
        $this->seedSettings();
    }

    private function seedPersonalInfo(): void
    {
        if (PersonalInfo::exists()) {
            return;
        }

        $info = PersonalInfo::create([
            'name'          => 'مهدی یوسفی',
            'name_en'       => 'Mahdi Yousefi',
            'job_title'     => 'توسعه‌دهنده Back-End | متخصص Laravel و PHP',
            'job_title_en'  => 'Back-End Developer | Laravel & PHP Specialist',
            'tagline'       => 'ساخت سیستم‌های وب مقیاس‌پذیر با Laravel — از فروشگاه چندفروشندگی تا پلتفرم‌های هوش مصنوعی',
            'tagline_en'    => 'Building scalable web systems with Laravel — from multi-vendor stores to AI-powered platforms',
            'bio'           => "برنامه‌نویس وب با بیش از ۵ سال تجربه عملی در طراحی و توسعه سایت‌ها و برنامه‌های کاربردی تحت وب.\n"
                . "تخصص اصلی من توسعه بک‌اند با فریم‌ورک Laravel است؛ از طراحی معماری دیتابیس و ساخت REST API تا پیاده‌سازی درگاه‌های پرداخت و امن‌سازی اپلیکیشن‌ها بر اساس اصول OWASP.\n"
                . "در این مدت بیش از ۱۲ پروژه تخصصی — شامل فروشگاه چندفروشندگی با معماری ماژولار، پلتفرم مدیریت حمل‌ونقل، چت‌بات هوش مصنوعی و افزونه‌های سفارشی وردپرس — طراحی، توسعه و راه‌اندازی کرده‌ام.",
            'bio_en'        => "A web developer with 5+ years of hands-on experience in designing and developing websites and web applications.\n"
                . "My core expertise is Back-End development with the Laravel framework: from database architecture and REST API design to payment gateway integrations and securing applications based on OWASP principles.\n"
                . "So far I have designed, built and launched more than 12 specialized projects — including a multi-vendor e-commerce ecosystem with modular architecture, a freight management platform, an AI chatbot and custom WordPress plugins.",
            'abilities'     => "توسعه بک‌اند با Laravel (Eloquent، REST API، Sanctum، Queue، Policies)\n"
                . "طراحی و بهینه‌سازی دیتابیس MySQL (ایندکس‌گذاری و بهینه‌سازی کوئری)\n"
                . "پیاده‌سازی درگاه‌های پرداخت ایرانی (زرین‌پال، دیجی‌پی، Pay.ir)\n"
                . "امنیت وب بر اساس اصول OWASP (CSRF، XSS، SQL Injection، Rate Limiting)\n"
                . "بهینه‌سازی سرعت بارگذاری با Redis، CDN و کش\n"
                . "توسعه پلاگین سفارشی وردپرس و یکپارچه‌سازی API\n"
                . "کار با OpenAI API و مهندسی پرامپت\n"
                . "حل مسائل پیچیده، کار تیمی و مدیریت پروژه",
            'abilities_en'  => "Back-End development with Laravel (Eloquent, REST API, Sanctum, Queue, Policies)\n"
                . "MySQL database design & query optimization (indexing)\n"
                . "Iranian payment gateway integrations (ZarinPal, Digipay, Pay.ir)\n"
                . "Web security based on OWASP (CSRF, XSS, SQL Injection, Rate Limiting)\n"
                . "Performance optimization with Redis, CDN & caching\n"
                . "Custom WordPress plugin development & API integration\n"
                . "OpenAI API usage & prompt engineering\n"
                . "Complex problem solving, teamwork & project management",
            'email'         => 'mahdi77yousefi2015@gmail.com',
            'phone'         => '09190478451',
            'website'       => 'webtpro.ir',
            'telegram'      => 'mrYou3fi',
            'birth_date'    => '۲۳ مرداد ۱۳۷۷',
            'birth_date_en' => 'August 14, 1998',
            'city'          => 'قزوین / تهران',
            'city_en'       => 'Qazvin / Tehran',
        ]);

        // اگر فایل PDF رزومه داخل seeders/files باشد، به‌صورت خودکار منتشر می‌شود
        $cvSource = database_path('seeders/files/Mahdi_Yousefi_Resume_FA.pdf');

        if (is_file($cvSource)) {
            Storage::disk('public')->putFileAs('cv', new \Illuminate\Http\File($cvSource), 'Mahdi_Yousefi_Resume_FA.pdf');
            $info->update(['cv_path' => 'cv/Mahdi_Yousefi_Resume_FA.pdf']);
        }
    }

    private function seedExperiences(): void
    {
        if (Experience::exists()) {
            return;
        }

        $items = [
            [
                'position'     => 'کارشناس پایش وب',
                'position_en'  => 'Web Monitoring Expert',
                'company'      => 'پلیس امنیت اقتصادی قزوین — حوزه اقتصاد دیجیتال (خدمت سربازی)',
                'company_en'   => 'Cyber Police of Qazvin — Digital Economy Unit (Military Service)',
                'period'       => 'خرداد ۱۴۰۳ — اسفند ۱۴۰۴',
                'period_en'    => 'Jun 2024 — Mar 2026',
                'is_current'   => false,
                'description'  => "پایش و بررسی مستمر سایت‌های متخلف و شناسایی فعالیت‌های غیرقانونی در حوزه اقتصاد دیجیتال\n"
                    . "تحلیل ساختار سایت‌ها و شناسایی تکنیک‌های پنهان‌کاری در وب\n"
                    . "تهیه گزارش فنی از تخلفات آنلاین و همکاری با تیم پیگیری حقوقی",
                'description_en' => "Continuous monitoring of violating websites and detecting unlawful activities in the digital economy\n"
                    . "Analyzing website structures and identifying hidden manipulation techniques\n"
                    . "Preparing technical reports and cooperating with the legal follow-up team",
                'sort_order'   => 1,
            ],
            [
                'position'     => 'توسعه‌دهنده Back-End',
                'position_en'  => 'Back-End Developer',
                'company'      => 'شرکت توسعه اقتصادی شهر قزوین (وابسته به شهرداری)',
                'company_en'   => 'Qazvin Urban Economic Development Co. (Municipality Affiliate)',
                'period'       => 'تیر ۱۴۰۱ — خرداد ۱۴۰۲',
                'period_en'    => 'Jul 2022 — Jun 2023',
                'is_current'   => false,
                'description'  => "توسعه Back-End فروشگاه اینترنتی و پلتفرم تجارت الکترونیک با Laravel\n"
                    . "طراحی CMS چندفروشندگی با مدیریت سفارشات، کامیسیون‌ها و درگاه پرداخت",
                'description_en' => "Back-End development of an online store and e-commerce platform with Laravel\n"
                    . "Designing a multi-vendor CMS with orders, commissions and payment gateway management",
                'sort_order'   => 2,
            ],
            [
                'position'     => 'توسعه‌دهنده ارشد PHP',
                'position_en'  => 'Senior PHP Developer',
                'company'      => 'فریلنسر — پروژه‌های متنوع',
                'company_en'   => 'Freelancer — Various Projects',
                'period'       => 'مهر ۱۳۹۸ — دی ۱۴۰۰',
                'period_en'    => 'Oct 2019 — Jan 2022',
                'is_current'   => false,
                'description'  => "طراحی و توسعه بیش از ۱۲ سایت تخصصی با PHP و Laravel\n"
                    . "توسعه پلاگین‌های سفارشی وردپرس، REST API و یکپارچه‌سازی درگاه پرداخت",
                'description_en' => "Design and development of 12+ specialized websites with PHP & Laravel\n"
                    . "Custom WordPress plugins, REST APIs and payment gateway integrations",
                'sort_order'   => 3,
            ],
        ];

        foreach ($items as $item) {
            Experience::create($item);
        }
    }

    private function seedEducations(): void
    {
        if (Education::exists()) {
            return;
        }

        $items = [
            [
                'degree'        => 'کارشناسی مهندسی کامپیوتر',
                'degree_en'     => 'B.Sc. in Computer Engineering',
                'institution'   => 'دانشگاه آزاد اسلامی قزوین',
                'institution_en' => 'Payam Noor University of Qazvin',
                'period'        => '۱۳۹۹ - ۱۴۰۲',
                'period_en'     => '2020 - 2023',
                'sort_order'    => 1,
            ],
            [
                'degree'        => 'کاردانی مهندسی کامپیوتر',
                'degree_en'     => 'Associate Degree in Computer Engineering',
                'institution'   => 'دانشگاه آزاد قزوین',
                'institution_en' => 'Islamic Azad University of Qazvin',
                'period'        => '۱۳۹۷ - ۱۳۹۹',
                'period_en'     => '2018 - 2020',
                'sort_order'    => 2,
            ],
            [
                'degree'        => 'گواهینامه ICDL',
                'degree_en'     => 'ICDL Certificate',
                'institution'   => 'دوره تخصصی',
                'institution_en' => 'Professional Course',
                'sort_order'    => 3,
            ],
            [
                'degree'        => 'تکنسین شبکه',
                'degree_en'     => 'Network Technician',
                'institution'   => 'سازمان فنی و حرفه‌ای کشور',
                'institution_en' => 'Technical & Vocational Training Organization',
                'sort_order'    => 4,
            ],
        ];

        foreach ($items as $item) {
            Education::create($item);
        }
    }

    private function seedSkills(): void
    {
        if (Skill::exists()) {
            return;
        }

        // دسته‌بندی‌های مهارت — ستون level خالی = نمایش به‌صورت تگ
        $groups = [
            ['fa' => 'Backend & CMS',        'en' => 'Backend & CMS',        'skills' => [
                ['Laravel', 'Laravel'], ['PHP', 'PHP'], ['REST API', 'REST API'], ['Eloquent', 'Eloquent'],
                ['Sanctum', 'Sanctum'], ['Queue', 'Queue'], ['WordPress', 'WordPress'], ['Plugin Dev', 'Plugin Dev'],
            ]],
            ['fa' => 'Frontend',             'en' => 'Frontend',             'skills' => [
                ['HTML5', 'HTML5'], ['CSS3', 'CSS3'], ['JavaScript', 'JavaScript'], ['jQuery', 'jQuery'],
            ]],
            ['fa' => 'Database & DevOps',    'en' => 'Database & DevOps',    'skills' => [
                ['MySQL', 'MySQL'], ['Redis', 'Redis'], ['Docker', 'Docker'], ['Git/GitHub', 'Git/GitHub'],
            ]],
            ['fa' => 'AI & Integration',     'en' => 'AI & Integration',     'skills' => [
                ['OpenAI API', 'OpenAI API'], ['Prompt Eng.', 'Prompt Eng.'], ['Google Maps', 'Google Maps'],
                ['Firebase', 'Firebase'], ['Pusher', 'Pusher'],
            ]],
            ['fa' => 'Payment & Security',   'en' => 'Payment & Security',   'skills' => [
                ['درگاه‌های پرداخت', 'Payment Gateways'], ['Digipay', 'Digipay'], ['CSRF/XSS', 'CSRF/XSS'],
                ['Rate Limiting', 'Rate Limiting'], ['OAuth2', 'OAuth2'],
            ]],
            ['fa' => 'زبان‌ها',               'en' => 'Languages',            'level' => true, 'skills' => [
                ['فارسی', 'Persian', 100], ['انگلیسی', 'English', 55],
            ]],
        ];

        $order = 0;

        foreach ($groups as $group) {
            foreach ($group['skills'] as $index => $skill) {
                Skill::create([
                    'category'    => $group['fa'],
                    'category_en' => $group['en'],
                    'name'        => $skill[0],
                    'name_en'     => $skill[1],
                    'level'       => $skill[2] ?? null,
                    'sort_order'  => $order++,
                ]);
            }
        }
    }

    private function seedPortfolios(): void
    {
        if (Portfolio::exists()) {
            return;
        }

        $items = [
            [
                'title'        => 'اوپا شاپ (OpaShop)',
                'title_en'     => 'OpaShop',
                'category'     => 'فروشگاه آنلاین',
                'category_en'  => 'E-Commerce',
                'url'          => 'https://opashop.ir',
                'is_featured'  => true,
                'tech_tags'    => 'Laravel 13, PHP 8.3, MySQL 8, Redis, Sanctum, REST API',
                'description'  => "اکوسیستم تجارت الکترونیک چندفروشندگی با معماری ماژولار — بی‌نظیر در جهان.\n"
                    . "شامل سیستم خرید اعتباری، پرداخت اقساطی (BNPL)، اسمبل هوشمند قطعات با ۸ پرووایدر هوش مصنوعی، سئو چندپرووایدری، درگاه دیجی‌پی با OAuth2 و مدیریت جامع فروشندگان.\n"
                    . "هر قابلیت به‌صورت ماژول مستقل با لایسنس قابل فروش پیاده‌سازی شده و معماری Unified Payment Gateway Resolver افزودن درگاه جدید را بدون تغییر منطق Checkout ممکن می‌کند.",
                'description_en' => "A one-of-a-kind multi-vendor e-commerce ecosystem with modular architecture.\n"
                    . "Includes a credit shopping system, installment payments (BNPL), AI-powered PC assembly with 8 AI providers, multi-provider SEO, Digipay gateway with OAuth2 and full vendor management.\n"
                    . "Every feature ships as an independent licensed module, and the Unified Payment Gateway Resolver pattern makes adding new gateways seamless without touching checkout logic.",
                'sort_order'   => 1,
            ],
            [
                'title'        => 'پلتفرم مدیریت بار و حمل‌ونقل (مشابه اسنپ)',
                'title_en'     => 'Freight & Transportation Platform',
                'category'     => 'پلتفرم',
                'category_en'  => 'Platform',
                'client'       => 'وب کام (Webkam)',
                'client_en'    => 'Webkam',
                'is_featured'  => true,
                'tech_tags'    => 'Laravel, Google Maps API, Pusher, Firebase, Microservices',
                'description'  => "سیستم جامع مدیریت حمل‌ونقل و اختصاص بار به رانندگان بر اساس معماری میکروسرویس، مشابه اسنپ.\n"
                    . "شامل ثبت‌نام چندمرحله‌ای رانندگان، مدیریت بارها با فیلترهای جغرافیایی و وزنی، پیشنهاد قیمت، چت داخلی با دیسپچر و ردیابی لحظه‌ای موقعیت رانندگان با GPS و Google Maps API.\n"
                    . "نتیجه: کاهش زمان اختصاص بار، افزایش بهره‌وری و ردیابی دقیق محموله‌ها.",
                'description_en' => "A comprehensive freight management and load assignment system for drivers, built on a microservice architecture (similar to Snapp).\n"
                    . "Includes multi-step driver registration, load management with geo/weight filters, price offers, in-app chat with dispatchers and real-time GPS tracking via Google Maps API.\n"
                    . "Result: faster load assignment, higher productivity and precise shipment tracking.",
                'sort_order'   => 2,
            ],
            [
                'title'        => 'چت‌بات هوش مصنوعی',
                'title_en'     => 'AI Chatbot',
                'category'     => 'هوش مصنوعی',
                'category_en'  => 'AI',
                'client'       => 'وب کام (Webkam)',
                'client_en'    => 'Webkam',
                'tech_tags'    => 'Laravel, OpenAI, Prompt Engineering',
                'description'  => "چت‌بات پیشرفته با تمرکز موضوعی که تنها به سؤالات حوزه‌های آموزش‌داده پاسخ می‌دهد.\n"
                    . "شامل دستیارهای تخصصی: تولید محتوا، سئو، آشپزی، ترجمه، حسابداری سپیدار، حسابداری هلو، تأمین اجتماعی و شهروندی.",
                'description_en' => "An advanced topic-focused chatbot that only answers questions within the domains it has been trained on.\n"
                    . "Includes specialized assistants for content creation, SEO, cooking, translation, Sepidar & Hesab accounting, social security and citizenship topics.",
                'sort_order'   => 3,
            ],
            [
                'title'        => 'دستیار هوشمند اینستاگرام',
                'title_en'     => 'Instagram AI Assistant',
                'category'     => 'هوش مصنوعی',
                'category_en'  => 'AI',
                'client'       => 'وب کام (Webkam)',
                'client_en'    => 'Webkam',
                'tech_tags'    => 'Laravel, AI',
                'description'  => "ابزار قدرتمند تولید محتوای حرفه‌ای اینستاگرام — با وارد کردن یک عنوان، پست کامل شامل تصویر، متن و هشتگ‌ها تولید می‌شود.\n"
                    . "دارای پکیج‌های متنوع با امکانات مختلف.",
                'description_en' => "A powerful tool for generating professional Instagram content — enter a single title and get a complete post including image, caption and hashtags.\n"
                    . "Offers various packages with different capabilities.",
                'sort_order'   => 4,
            ],
            [
                'title'        => 'سامانه رزرو آنلاین خدمات',
                'title_en'     => 'Online Booking System',
                'category'     => 'وردپرس',
                'category_en'  => 'WordPress',
                'client'       => 'وب کام (Webkam)',
                'client_en'    => 'Webkam',
                'tech_tags'    => 'WordPress, Bookly',
                'description'  => "سیستم رزرو نوبت آنلاین با تقویم تعاملی، یادآوری پیامکی و ایمیلی و پرداخت آنلاین/حضوری.\n"
                    . "سفارشی‌سازی کامل فرم‌ها و مدیریت کارکنان و خدمات.",
                'description_en' => "An online appointment booking system with an interactive calendar, SMS/email reminders and online/in-person payments.\n"
                    . "Fully customizable forms plus staff and service management.",
                'sort_order'   => 5,
            ],
            [
                'title'        => 'پلاگین ورود/ثبت‌نام OTP',
                'title_en'     => 'OTP Login WordPress Plugin',
                'category'     => 'وردپرس',
                'category_en'  => 'WordPress',
                'client'       => 'وب کام (Webkam)',
                'client_en'    => 'Webkam',
                'tech_tags'    => 'WordPress, SMS, WooCommerce',
                'description'  => "افزونه ورود و ثبت‌نام با شماره موبایل و OTP (مشابه دیجیتس)، یکپارچه با ووکامرس و پشتیبانی از درگاه‌های پیامک ایرانی مانند کاوه‌نگار و پیامک ملی.",
                'description_en' => "A WordPress plugin for login/registration via mobile number and OTP (similar to Digikala), fully integrated with WooCommerce and supporting Iranian SMS gateways such as Kavenegar and SMS.ir.",
                'sort_order'   => 6,
            ],
            [
                'title'        => 'سایت جستجوی آرایشگاه و رزرو',
                'title_en'     => 'Beauty Salon Directory & Booking',
                'category'     => 'وردپرس',
                'category_en'  => 'WordPress',
                'url'          => 'https://9batyar.com',
                'tech_tags'    => 'WordPress, Laravel',
                'description'  => "پلتفرم جامع جستجو و رزرو خدمات آرایشی با سیستم اشتراکی، پرداخت چندگانه (آنلاین/پیش‌پرداخت/حضوری)، گالری تصاویر، مدیریت نظرات و فیلترینگ آنی.",
                'description_en' => "A comprehensive beauty services search and booking platform with subscription plans, multiple payment options, image galleries, review management and instant filtering.",
                'sort_order'   => 7,
            ],
            [
                'title'        => 'سایت خدماتی انگلیسی',
                'title_en'     => 'Home Services Website (UK)',
                'category'     => 'وب‌سایت',
                'category_en'  => 'Website',
                'url'          => 'https://4seasonsclean.co.uk',
                'tech_tags'    => 'Laravel',
                'description'  => "وب‌سایت بین‌المللی رزرو خدمات خانگی (نظافت، شستشوی فرش) با رابط انگلیسی، پرداخت حضوری، سیستم نظرات و پنل مدیریت ارائه‌دهندگان خدمات.",
                'description_en' => "An international home-services booking website (cleaning, carpet washing) with an English interface, in-person payments, a review system and a provider management panel.",
                'sort_order'   => 8,
            ],
            [
                'title'        => 'فروشگاه Mersiz',
                'title_en'     => 'Mersiz Store',
                'category'     => 'فروشگاه آنلاین',
                'category_en'  => 'E-Commerce',
                'url'          => 'https://mersiz.com',
                'tech_tags'    => 'Laravel',
                'description'  => "پلتفرم فروشگاهی با فیلتر آنی محصولات، رزرو کالا و پرداخت از کیف پول.",
                'description_en' => "An e-commerce platform with instant product filtering, product reservation and wallet-based payments.",
                'sort_order'   => 9,
            ],
            [
                'title'        => 'رستوران نمونه نارون',
                'title_en'     => 'Nemooneh Restaurant',
                'category'     => 'وب‌سایت',
                'category_en'  => 'Website',
                'url'          => 'http://nemoonehrestaurant.com',
                'tech_tags'    => 'PHP',
                'description'  => "طراحی و توسعه وب‌سایت دوزبانه (فارسی و انگلیسی) برای رستوران.",
                'description_en' => "Design and development of a bilingual (Persian/English) restaurant website.",
                'sort_order'   => 10,
            ],
            [
                'title'        => 'بازاریابی شبکه‌ای',
                'title_en'     => 'MLM Platform',
                'category'     => 'وب‌سایت',
                'category_en'  => 'Website',
                'url'          => 'http://vahdatroyaha.com',
                'tech_tags'    => 'Laravel, Algorithm',
                'description'  => "پیاده‌سازی سیستم بازاریابی شبکه‌ای با الگوریتم پلن تعادل (باینری)، دایرکت سلینگ، لیدرشیپ و محاسبه چندمدلی پورسانت.",
                'description_en' => "Implementation of a network marketing system with a binary balance plan, direct selling, leadership tiers and multi-model commission calculation.",
                'sort_order'   => 11,
            ],
            [
                'title'        => 'اکوتوریسم الموت',
                'title_en'     => 'Alamut Ecotourism',
                'category'     => 'وب‌سایت',
                'category_en'  => 'Website',
                'url'          => 'http://alamutecotourism.com',
                'tech_tags'    => 'WordPress',
                'description'  => "وب‌سایت گردشگری الموت با رزرو تور، اقامتگاه‌های بوم‌گردی و فروشگاه آنلاین محصولات محلی.",
                'description_en' => "The Alamut tourism website with tour booking, eco-lodge reservations and an online store for local products.",
                'sort_order'   => 12,
            ],
        ];

        foreach ($items as $item) {
            Portfolio::create($item);
        }
    }

    private function seedTestimonials(): void
    {
        if (Testimonial::exists()) {
            return;
        }

        // ⚠️ این موارد نمونه هستند — از پنل مدیریت با نظرات واقعی جایگزین کنید
        $items = [
            [
                'name'        => 'مدیر فنی وب کام',
                'name_en'     => 'Technical Manager, Webkam',
                'position'    => 'کارفرمای پروژه‌های پلتفرم حمل‌ونقل و چت‌بات',
                'position_en' => 'Client — Freight Platform & AI Chatbot projects',
                'content'     => "همکاری با مهدی در پروژه‌های متنوع از جمله پلتفرم حمل‌ونقل و چت‌بات هوش مصنوعی، همواره دقیق، منظم و حرفه‌ای بوده است. تسلط او بر Laravel و معماری سیستم‌ها باعث شد پروژه‌ها سریع‌تر از انتظار به نتیجه برسند.",
                'content_en'  => "Working with Mahdi on various projects — including the freight platform and AI chatbot — was always precise, organized and professional. His command of Laravel and system architecture delivered results faster than expected.",
                'sort_order'  => 1,
            ],
            [
                'name'        => 'کارفرمای پروژه اوپا شاپ',
                'name_en'     => 'OpaShop Project Owner',
                'position'    => 'پروژه فروشگاه چندفروشندگی',
                'position_en' => 'Multi-vendor e-commerce project',
                'content'     => "معماری ماژولاری که مهدی برای اوپا شاپ طراحی کرد، توسعه ماژول‌های جدید را بسیار ساده کرده است. درگاه پرداخت جدید بدون تغییر در منطق Checkout اضافه شد — دقیقاً همان چیزی که می‌خواستیم.",
                'content_en'  => "The modular architecture Mahdi designed for OpaShop made developing new modules incredibly simple. A new payment gateway was added without touching the checkout logic — exactly what we wanted.",
                'sort_order'  => 2,
            ],
            [
                'name'        => 'مدیر پروژه — شرکت توسعه اقتصادی شهر قزوین',
                'name_en'     => 'Project Manager — Qazvin Urban Economic Development Co.',
                'position'    => 'کارفرمای فروشگاه اینترنتی شهرداری',
                'position_en' => 'Client — Municipality e-commerce platform',
                'content'     => "پیگیری مستمر، کدنویسی تمیز و رعایت ددلاین‌ها از ویژگی‌های بارز کار مهدی در پروژه فروشگاه اینترنتی بود. CMS چندفروشندگی دقیقاً طبق نیازسنجی تحویل داده شد.",
                'content_en'  => "Consistent follow-up, clean code and strict adherence to deadlines were the hallmarks of Mahdi's work on our e-commerce project. The multi-vendor CMS was delivered exactly per the requirements.",
                'sort_order'  => 3,
            ],
        ];

        foreach ($items as $item) {
            Testimonial::create($item);
        }
    }

    private function seedSocialLinks(): void
    {
        if (SocialLink::exists()) {
            return;
        }

        $items = [
            ['platform' => 'ایمیل',     'url' => 'mailto:mahdi77yousefi2015@gmail.com', 'icon' => 'fa-solid fa-envelope',   'sort_order' => 1],
            ['platform' => 'تلفن',      'url' => 'tel:09190478451',                    'icon' => 'fa-solid fa-phone',      'sort_order' => 2],
            ['platform' => 'تلگرام',    'url' => 'https://t.me/mrYou3fi',              'icon' => 'fa-brands fa-telegram',  'sort_order' => 3],
            ['platform' => 'وب‌ت‌پرو',   'url' => 'https://webtpro.ir',                 'icon' => 'fa-solid fa-globe',      'sort_order' => 4],
            ['platform' => 'اوپا شاپ',  'url' => 'https://opashop.ir',                 'icon' => 'fa-solid fa-bag-shopping', 'sort_order' => 5],
        ];

        foreach ($items as $item) {
            SocialLink::create($item);
        }
    }

    private function seedSettings(): void
    {
        if (Setting::exists()) {
            return;
        }

        Setting::create([
            'site_title'            => 'مهدی یوسفی',
            'site_title_en'         => 'Mahdi Yousefi',
            'meta_description'      => 'رزومه و نمونه‌کارهای مهدی یوسفی — توسعه‌دهنده Back-End و متخصص Laravel و PHP با بیش از ۵ سال تجربه',
            'meta_description_en'   => "Mahdi Yousefi's resume and portfolio — Back-End Developer and Laravel & PHP specialist with 5+ years of experience",
            'footer_text'           => 'طراحی و توسعه با Laravel',
            'footer_text_en'        => 'Designed & developed with Laravel',
            'contact_intro'         => 'برای همکاری، مشاوره یا هر سؤالی، از راه‌های زیر با من در تماس باشید یا مستقیماً پیام بگذارید.',
            'contact_intro_en'      => "For collaboration, consulting or any question, reach me through the channels below or just leave a message.",
        ]);
    }
}
