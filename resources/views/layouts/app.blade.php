<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ═════════════ SEO پایه ═════════════ --}}
    <title>{{ $settings->t('site_title') }}</title>
    <meta name="description" content="{{ $settings->t('meta_description') }}">
    <meta name="author" content="{{ $info->t('name') }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#0b1220">
    <meta name="format-detection" content="telephone=no">

    {{-- ═════════════ Canonical + Hreflang (چندزبانه) ═════════════ --}}
    @php
        $canonicalUrl = route('home', ['locale' => app()->getLocale()]);
        $urlFa        = route('home', ['locale' => 'fa']);
        $urlEn        = route('home', ['locale' => 'en']);
    @endphp
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="fa" href="{{ $urlFa }}">
    <link rel="alternate" hreflang="en" href="{{ $urlEn }}">
    <link rel="alternate" hreflang="x-default" href="{{ $urlEn }}">

    {{-- ═════════════ Open Graph ═════════════ --}}
    <meta property="og:type" content="profile">
    <meta property="og:site_name" content="{{ $info->t('name') }}">
    <meta property="og:title" content="{{ $info->t('name') }} | {{ $info->t('job_title') }}">
    <meta property="og:description" content="{{ $settings->t('meta_description') }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'fa' ? 'fa_IR' : 'en_US' }}">
    <meta property="og:locale:alternate" content="{{ app()->getLocale() === 'fa' ? 'en_US' : 'fa_IR' }}">
    @if (!empty($settings->og_image ?? $info->t('avatar') ?? null))
        <meta property="og:image" content="{{ $settings->og_image ?? asset($info->t('avatar')) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $info->t('name') }} | {{ $info->t('job_title') }}">
    @endif

    {{-- ═════════════ Twitter Card ═════════════ --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $info->t('name') }} | {{ $info->t('job_title') }}">
    <meta name="twitter:description" content="{{ $settings->t('meta_description') }}">
    @if (!empty($settings->og_image ?? $info->t('avatar') ?? null))
        <meta name="twitter:image" content="{{ $settings->og_image ?? asset($info->t('avatar')) }}">
    @endif

    {{-- ═════════════ آیکون‌ها ═════════════ --}}
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='24' fill='%230b1220'/><text x='50' y='68' font-size='52' font-family='Arial' font-weight='bold' text-anchor='middle' fill='%232dd4bf'>M</text></svg>">
    <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='24' fill='%230b1220'/><text x='50' y='68' font-size='52' font-family='Arial' font-weight='bold' text-anchor='middle' fill='%232dd4bf'>M</text></svg>">

    {{-- ═════════════ Structured Data (JSON-LD) — کلید دیده‌شدن در جستجوی AI ═════════════ --}}
    <script type="application/ld+json">
        {!! json_encode([
            '@context'    => "https://schema.org",
            '@type'       => "Person",
            "name"        => $info->t('name'),
            "jobTitle"    => $info->t('job_title'),
            "description" => $settings->t('meta_description'),
            "url"         => $canonicalUrl,
            "sameAs"      => collect($socials)->pluck('url')->values()->all(),
            "knowsAbout"  => $info->jobTitles(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
    </script>
    <script type="application/ld+json">
        {!! json_encode([
            '@context'    => "https://schema.org",
            '@type'       => "WebSite",
            "name"        => $settings->t('site_title'),
            "url"         => $canonicalUrl,
            "inLanguage"  => app()->getLocale(),
            "description" => $settings->t('meta_description'),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}
    </script>

    {{-- ═════════════ Preconnect برای منابع خارجی (سرعت = سئو) ═════════════ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <link rel="dns-prefetch" href="https://unpkg.com">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#070d1a', 900: '#0b1220', 800: '#111a2e', 700: '#182444' },
                        brand: { 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488' },
                        gold: { 400: '#fbbf24', 500: '#f59e0b' },
                    },
                    fontFamily: {
                        sans: ["{{ app()->getLocale() === 'fa' ? 'Vazirmatn' : 'Inter' }}", "Vazirmatn", "Inter", "ui-sans-serif", "system-ui", "sans-serif"],
                    },
                    animation: {
                        float: 'float 6s ease-in-out infinite',
                        'float-slow': 'float 9s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-16px)' },
                        },
                    },
                }
            }
        }
    </script>

    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style type="text/tailwindcss">
        .glass    { @apply bg-white/[0.04] border border-white/10 backdrop-blur-xl; }
        .chip     { @apply inline-flex items-center gap-2 rounded-full border border-brand-400/30 bg-brand-400/10 px-4 py-1.5 text-xs font-bold text-brand-300; }
        .f-btn    { @apply inline-flex items-center justify-center gap-2 rounded-2xl px-6 py-3 text-sm font-bold transition select-none; }
        .f-btn-primary { @apply f-btn bg-gradient-to-l from-brand-500 to-sky-500 text-navy-950 shadow-lg shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5; }
        .f-btn-ghost   { @apply f-btn border border-white/15 bg-white/5 text-white hover:border-brand-400/50 hover:bg-white/10 hover:-translate-y-0.5; }
        .f-input  { @apply w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-3.5 text-sm text-white placeholder-slate-500 outline-none transition focus:border-brand-400/60 focus:bg-white/[0.07] focus:ring-4 focus:ring-brand-400/10; }
        .sec-title { @apply text-3xl font-black text-white md:text-4xl; }
        .tech-tag { @apply inline-flex items-center rounded-lg border border-white/10 bg-white/5 px-2.5 py-1 text-[11px] font-bold text-slate-300; }
    </style>

    <style>
        html { scroll-behavior: smooth; scroll-padding-top: 96px; }

        /* الگوی گرید پس‌زمینه */
        .bg-grid {
            background-image:
                linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, black 40%, transparent 100%);
            -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, black 40%, transparent 100%);
        }

        /* منوی اسکرول فعال */
        .nav-link.active { color: #5eead4; }
        .nav-link.active::after { transform: scaleX(1); }
        .nav-link::after {
            content: '';
            position: absolute;
            inset-inline-start: 0;
            bottom: -6px;
            width: 100%;
            height: 2px;
            border-radius: 2px;
            background: linear-gradient(90deg, #14b8a6, #38bdf8);
            transform: scaleX(0);
            transform-origin: center;
            transition: transform .3s ease;
        }

        /* کرسر افکت تایپ */
        .typing-cursor {
            display: inline-block;
            width: 3px;
            height: 1em;
            margin-inline-start: 4px;
            background: #2dd4bf;
            animation: blink 1s step-end infinite;
            vertical-align: -0.15em;
        }
        @keyframes blink { 50% { opacity: 0; } }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* مودال نمونه‌کار: انیمیشن ورود */
        @keyframes pm-pop {
            from { opacity: 0; transform: scale(.95) translateY(16px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        #portfolio-modal .pm-shell { animation: pm-pop .38s cubic-bezier(.16, 1, .3, 1) both; }

        /* لایت‌باکس تمام‌صفحه */
        @keyframes pm-fade { from { opacity: 0; } to { opacity: 1; } }
        #portfolio-lightbox { animation: pm-fade .25s ease both; }
        #portfolio-lightbox img { animation: pm-pop .3s cubic-bezier(.16, 1, .3, 1) both; }

        /* اسکرول‌بار باریک بندانگشتی‌ها و جزئیات مودال */
        .pm-thumbs::-webkit-scrollbar { height: 6px; }
        .pm-thumbs::-webkit-scrollbar-track { background: transparent; }
        .pm-thumbs::-webkit-scrollbar-thumb { background: #182444; border-radius: 8px; }
        .pm-thumbs::-webkit-scrollbar-thumb:hover { background: #2dd4bf; }
        .pm-details::-webkit-scrollbar { width: 6px; }
        .pm-details::-webkit-scrollbar-track { background: transparent; }
        .pm-details::-webkit-scrollbar-thumb { background: #182444; border-radius: 8px; }

        /* اسکرول‌بار */
        ::-webkit-scrollbar { width: 9px; }
        ::-webkit-scrollbar-track { background: #0b1220; }
        ::-webkit-scrollbar-thumb { background: #182444; border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: #2dd4bf; }

        ::selection { background: rgba(45, 212, 191, 0.3); color: #fff; }
        .dir-ltr{
            direction: ltr;
        }
    </style>
</head>
<body class="bg-navy-900 font-sans text-slate-300 antialiased">

@php
    $navItems = array_values(array_filter([
        $settings->show_about        ? ['id' => 'about',        'label' => __('app.nav.about')]        : null,
        $settings->show_experience   ? ['id' => 'experience',   'label' => __('app.nav.experience')]   : null,
        $settings->show_education    ? ['id' => 'education',    'label' => __('app.nav.education')]    : null,
        $settings->show_skills       ? ['id' => 'skills',       'label' => __('app.nav.skills')]       : null,
        $settings->show_portfolios   ? ['id' => 'portfolios',   'label' => __('app.nav.portfolio')]    : null,
        $settings->show_testimonials ? ['id' => 'testimonials', 'label' => __('app.nav.testimonials')] : null,
        $settings->show_contact      ? ['id' => 'contact',      'label' => __('app.nav.contact')]      : null,
    ]));

    $otherLocale = app()->getLocale() === 'fa' ? 'en' : 'fa';
@endphp

{{-- ═════════════════════════ ناوبری ═════════════════════════ --}}
<header id="main-nav" class=" inset-x-0 top-0 z-50 transition-all duration-300">
    <nav class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-4 lg:px-8" aria-label="{{ __('app.nav.main_nav') ?? 'Main navigation' }}">
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
           class="flex h-11  items-center justify-center rounded-2xl from-brand-400 to-sky-500 text-base font-black text-navy-950 shadow-lg transition hover:scale-105 dir-ltr"
           aria-label="{{ $info->t('name') }}">
            <svg width="180" height="44" viewBox="0 0 180 44" xmlns="http://www.w3.org/2000/svg" style="margin-right: -70px" role="img" aria-label="{{ $info->t('name') }} logo">
                <defs>
                    <linearGradient id="sealGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#33D6B9"></stop>
                        <stop offset="100%" stop-color="#1AA88F"></stop>
                    </linearGradient>
                </defs>
                <polygon points="22,3 38.45,12.5 38.45,31.5 22,41 5.55,31.5 5.55,12.5" fill="url(#sealGrad3)" stroke="#E0AC4E" stroke-width="1.6"></polygon>
                <g stroke="#16211D" stroke-width="1.3" stroke-opacity="0.85">
                    <line x1="22" y1="16" x2="15.5" y2="27"></line>
                    <line x1="22" y1="16" x2="28.5" y2="27"></line>
                    <line x1="15.5" y1="27" x2="28.5" y2="27"></line>
                </g>
                <g fill="#16211D">
                    <circle cx="22" cy="16" r="2.3"></circle>
                    <circle cx="15.5" cy="27" r="2.3"></circle>
                    <circle cx="28.5" cy="27" r="2.3"></circle>
                </g>
                <text x="50" y="29" font-family="'Outfit','Segoe UI',sans-serif" font-weight="600" font-size="22" letter-spacing="-0.3">
                    <tspan fill="#F4EFE4">web</tspan><tspan fill="#E0AC4E">lak</tspan>
                </text>
            </svg>
        </a>

        {{-- لینک‌ها --}}
        <ul class="hidden items-center gap-7 lg:flex">
            @foreach ($navItems as $item)
                <li>
                    <a href="#{{ $item['id'] }}" data-spy="{{ $item['id'] }}"
                       class="nav-link relative text-sm font-bold text-slate-300 transition hover:text-brand-300">
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="flex items-center gap-3">
            {{-- سوییچ زبان --}}
            <a href="{{ route('lang.switch', $otherLocale) }}"
               class="flex items-center gap-1.5 rounded-full border border-white/10 bg-white/5 px-3.5 py-2 text-xs font-black text-slate-300 transition hover:border-brand-400/40 hover:text-brand-300"
               title="{{ __('app.nav.switch_lang') }}"
               hreflang="{{ $otherLocale }}"
               rel="alternate">
                <i class="fa-solid fa-globe text-brand-400" aria-hidden="true"></i>
                {{ $otherLocale === 'fa' ? 'فارسی' : 'English' }}
            </a>

            {{-- همبرگر موبایل --}}
            <button id="nav-burger" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white lg:hidden" aria-label="{{ __('app.nav.open_menu') ?? 'Open menu' }}" aria-expanded="false" aria-controls="nav-mobile">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </nav>

    {{-- منوی موبایل --}}
    <div id="nav-mobile" class="hidden border-t border-white/10 bg-navy-950/95 backdrop-blur-xl lg:hidden">
        <ul class="mx-auto max-w-6xl space-y-1 px-5 py-4">
            @foreach ($navItems as $item)
                <li>
                    <a href="#{{ $item['id'] }}" class="mobile-link block rounded-xl px-4 py-3 text-sm font-bold text-slate-300 transition hover:bg-white/5 hover:text-brand-300">
                        <i class="fa-solid fa-angle-{{ app()->getLocale() === 'fa' ? 'left' : 'right' }} me-2 text-brand-400" aria-hidden="true"></i>
                        {{ $item['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</header>

{{-- ═════════════════════════ محتوا ═════════════════════════ --}}
<main>
    {{-- توست پیام موفقیت فرم تماس --}}
    @if (session('contact_success'))
        <div id="flash-toast"
             class="fixed top-24 start-1/2 z-[70] flex -translate-x-1/2 items-center gap-3 rounded-2xl border border-brand-400/30 bg-navy-800/95 px-6 py-4 text-sm font-bold text-white shadow-2xl shadow-brand-500/20 backdrop-blur transition-all duration-400"
             dir="auto" role="status" aria-live="polite">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-400/15 text-brand-300">
                <i class="fa-solid fa-check" aria-hidden="true"></i>
            </span>
            {{ session('contact_success') }}
        </div>
    @endif

    @yield('content')
</main>

{{-- ═════════════════════════ فوتر ═════════════════════════ --}}
<footer class="border-t border-white/10 bg-navy-950/60 py-10">
    <div class="mx-auto flex max-w-6xl flex-col items-center gap-5 px-5 lg:px-8">
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}"
           class="flex h-12 items-center justify-center rounded-2xl from-brand-400 to-sky-500 text-lg font-black text-navy-950 dir-ltr"
           aria-label="{{ $info->t('name') }}">
            <svg width="180" height="44" viewBox="0 0 180 44" xmlns="http://www.w3.org/2000/svg" style="margin-right: -53px" role="img" aria-label="{{ $info->t('name') }} logo">
                <defs>
                    <linearGradient id="sealGrad4" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#33D6B9"></stop>
                        <stop offset="100%" stop-color="#1AA88F"></stop>
                    </linearGradient>
                </defs>
                <polygon points="22,3 38.45,12.5 38.45,31.5 22,41 5.55,31.5 5.55,12.5" fill="url(#sealGrad4)" stroke="#E0AC4E" stroke-width="1.6"></polygon>
                <g stroke="#16211D" stroke-width="1.3" stroke-opacity="0.85">
                    <line x1="22" y1="16" x2="15.5" y2="27"></line>
                    <line x1="22" y1="16" x2="28.5" y2="27"></line>
                    <line x1="15.5" y1="27" x2="28.5" y2="27"></line>
                </g>
                <g fill="#16211D">
                    <circle cx="22" cy="16" r="2.3"></circle>
                    <circle cx="15.5" cy="27" r="2.3"></circle>
                    <circle cx="28.5" cy="27" r="2.3"></circle>
                </g>
                <text x="50" y="29" font-family="'Outfit','Segoe UI',sans-serif" font-weight="600" font-size="22" letter-spacing="-0.3">
                    <tspan fill="#F4EFE4">web</tspan><tspan fill="#E0AC4E">lak</tspan>
                </text>
            </svg>
        </a>

        <div class="flex items-center gap-2">
            @foreach ($socials as $social)
                <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer me" title="{{ $social->platform }}"
                   class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-slate-400 transition hover:border-brand-400/50 hover:text-brand-300">
                    <i class="{{ $social->icon }}" aria-hidden="true"></i>
                    <span class="sr-only">{{ $social->platform }}</span>
                </a>
            @endforeach
        </div>

        <p class="text-center text-xs leading-relaxed text-slate-500">
            © {{ now()->year }} {{ $info->t('name') }} — {{ $settings->t('footer_text') }}
        </p>
    </div>
</footer>

{{-- دکمه بازگشت به بالا --}}
<button id="back-to-top"
        class="fixed bottom-6 end-6 z-40 flex h-11 w-11 translate-y-20 items-center justify-center rounded-xl bg-brand-500 text-navy-950 opacity-0 shadow-lg shadow-brand-500/40 transition-all hover:bg-brand-400"
        aria-label="{{ __('app.nav.back_to_top') ?? 'بازگشت به بالا' }}">
    <i class="fa-solid fa-arrow-up" aria-hidden="true"></i>
</button>

{{-- ═════════════════════════ اسکریپت‌ها ═════════════════════════ --}}
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    // انیمیشن اسکرول
    AOS.init({ once: true, duration: 700, offset: 60, easing: 'ease-out-cubic' });

    // ناوبری هنگام اسکرول
    const nav = document.getElementById('main-nav');
    const backToTop = document.getElementById('back-to-top');

    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY > 30;
        nav.classList.toggle('bg-navy-950/85', scrolled);
        nav.classList.toggle('backdrop-blur-xl', scrolled);
        nav.classList.toggle('shadow-lg', scrolled);
        nav.classList.toggle('shadow-black/20', scrolled);

        // دکمه بازگشت به بالا
        const showTop = window.scrollY > 500;
        backToTop.classList.toggle('opacity-0', !showTop);
        backToTop.classList.toggle('translate-y-20', !showTop);

        // اسکرول‌اسپای
        let current = '';
        document.querySelectorAll('section[id]').forEach((section) => {
            if (window.scrollY >= section.offsetTop - 140) current = section.id;
        });
        document.querySelectorAll('.nav-link').forEach((link) => {
            link.classList.toggle('active', link.dataset.spy === current);
        });
    }, { passive: true });

    backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    // منوی موبایل
    const burger = document.getElementById('nav-burger');
    const mobileMenu = document.getElementById('nav-mobile');
    burger.addEventListener('click', () => {
        const isHidden = mobileMenu.classList.toggle('hidden');
        burger.setAttribute('aria-expanded', String(!isHidden));
    });
    document.querySelectorAll('.mobile-link').forEach((link) => {
        link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });

    // افکت تایپ
    (function () {
        const roles = @json($info->jobTitles());
        const el = document.getElementById('typing-text');
        if (!el || !roles.length) return;

        let roleIndex = 0, charIndex = 0, deleting = false;

        function tick() {
            const current = roles[roleIndex];
            el.textContent = current.slice(0, charIndex);

            if (!deleting && charIndex < current.length) {
                charIndex++;
                setTimeout(tick, 70);
            } else if (!deleting) {
                deleting = true;
                setTimeout(tick, 1800);
            } else if (charIndex > 0) {
                charIndex--;
                setTimeout(tick, 38);
            } else {
                deleting = false;
                roleIndex = (roleIndex + 1) % roles.length;
                setTimeout(tick, 400);
            }
        }
        tick();
    })();

    // انیمیشن نوار مهارت‌ها
    const skillObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.width = entry.target.dataset.level + '%';
                skillObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.4 });
    document.querySelectorAll('.skill-bar-fill').forEach((bar) => skillObserver.observe(bar));

    // فیلتر نمونه‌کارها
    document.querySelectorAll('.portfolio-filter').forEach((btn) => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.portfolio-filter').forEach((b) => {
                b.classList.remove('bg-brand-500', 'text-navy-950', 'border-brand-500');
                b.classList.add('border-white/10', 'bg-white/5', 'text-slate-300');
            });
            btn.classList.add('bg-brand-500', 'text-navy-950', 'border-brand-500');
            btn.classList.remove('border-white/10', 'bg-white/5', 'text-slate-300');

            const filter = btn.dataset.filter;
            document.querySelectorAll('.portfolio-item').forEach((card) => {
                const show = filter === '*' || card.dataset.category === filter;
                card.classList.toggle('hidden', !show);
            });
        });
    });

    // ═══════════ مودال و گالری نمونه‌کار ═══════════
    (() => {
        const isFa = document.documentElement.lang === 'fa';
        const faNum = (v) => isFa ? String(v).replace(/\d/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[d]) : String(v);

        const modal = document.getElementById('portfolio-modal');
        if (!modal) return;

        const pmImage       = document.getElementById('pm-image');
        const pmPlaceholder = document.getElementById('pm-placeholder');
        const pmInitial     = document.getElementById('pm-initial');
        const pmPrev        = document.getElementById('pm-prev');
        const pmNext        = document.getElementById('pm-next');
        const pmCounter     = document.getElementById('pm-counter');
        const pmExpand      = document.getElementById('pm-expand');
        const pmThumbs      = document.getElementById('pm-thumbs');
        const pmDetails     = document.getElementById('pm-details');

        const lightbox  = document.getElementById('portfolio-lightbox');
        const lbImage   = document.getElementById('lb-image');
        const lbPrev    = document.getElementById('lb-prev');
        const lbNext    = document.getElementById('lb-next');
        const lbCounter = document.getElementById('lb-counter');

        let slides = [];
        let index  = 0;
        let alt    = '';

        const multiple = () => slides.length > 1;

        // بارگذاری نرم تصویر با محو شدن
        function fadeSwap(img, url) {
            if (!img || !url) return;
            img.style.opacity = '0';
            const pre = new Image();
            pre.onload = () => {
                img.src = url;
                requestAnimationFrame(() => { img.style.opacity = '1'; });
            };
            pre.src = url;
        }

        function buildThumbs() {
            if (!pmThumbs) return;
            pmThumbs.innerHTML = '';
            slides.forEach((url, i) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'ml-2 h-16 w-24 shrink-0 overflow-hidden rounded-xl border border-white/10 transition hover:opacity-90';

                const img = document.createElement('img');
                img.src = url;
                img.alt = '';
                img.loading = 'lazy';
                img.className = 'h-full w-full object-cover';

                btn.appendChild(img);
                btn.addEventListener('click', () => { index = i; renderStage(); });
                pmThumbs.appendChild(btn);
            });
        }

        function renderStage() {
            if (!slides.length) {
                pmImage?.classList.add('hidden');
                pmPlaceholder?.classList.remove('hidden');
                pmPrev?.classList.add('hidden');
                pmNext?.classList.add('hidden');
                pmCounter?.classList.add('hidden');
                pmExpand?.classList.add('hidden');
                pmThumbs?.classList.add('hidden');
                return;
            }

            pmPlaceholder?.classList.add('hidden');
            pmImage?.classList.remove('hidden');
            fadeSwap(pmImage, slides[index]);
            if (pmImage) pmImage.alt = alt;

            pmPrev?.classList.toggle('hidden', !multiple());
            pmNext?.classList.toggle('hidden', !multiple());
            pmCounter?.classList.toggle('hidden', !multiple());
            if (pmCounter) pmCounter.textContent = faNum(index + 1) + ' / ' + faNum(slides.length);

            if (pmThumbs) {
                pmThumbs.classList.toggle('hidden', !multiple());
                [...pmThumbs.children].forEach((btn, i) => {
                    btn.classList.toggle('ring-2', i === index);
                    btn.classList.toggle('ring-brand-400', i === index);
                    btn.classList.toggle('opacity-100', i === index);
                    btn.classList.toggle('opacity-50', i !== index);
                });
                pmThumbs.children[index]?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }

        function go(i) {
            if (!slides.length) return;
            index = (i + slides.length) % slides.length;
            renderStage();
            if (lightbox && !lightbox.classList.contains('hidden')) updateLightbox();
        }

        function openModal(article) {
            try { slides = JSON.parse(article.dataset.gallery || '[]'); } catch (e) { slides = []; }
            alt = article.dataset.title || '';
            index = 0;

            if (pmInitial) pmInitial.textContent = article.dataset.initial || '★';
            buildThumbs();

            const tpl = article.querySelector('.portfolio-data');
            if (pmDetails) pmDetails.innerHTML = tpl ? tpl.innerHTML : '';

            renderStage();
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            closeLightbox();
            document.body.style.overflow = '';
        }

        // ─── لایت‌باکس تمام‌صفحه ───
        function updateLightbox() {
            if (!lightbox) return;
            fadeSwap(lbImage, slides[index]);
            if (lbImage) lbImage.alt = alt;
            if (lbCounter) lbCounter.textContent = faNum(index + 1) + ' / ' + faNum(slides.length);
            lbPrev?.classList.toggle('hidden', !multiple());
            lbNext?.classList.toggle('hidden', !multiple());
            lbCounter?.classList.toggle('hidden', !multiple());
        }

        function openLightbox() {
            if (!lightbox || !slides.length) return;
            updateLightbox();
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
        }

        function closeLightbox() {
            if (!lightbox) return;
            lightbox.classList.add('hidden');
            lightbox.classList.remove('flex');
        }

        // ─── رویدادها ───
        document.querySelectorAll('.portfolio-item [data-open]').forEach((trigger) => {
            trigger.addEventListener('click', () => {
                const article = trigger.closest('.portfolio-item');
                if (article) openModal(article);
            });
        });

        modal.addEventListener('click', (e) => {
            if (!e.target.closest('.pm-shell')) closeModal();
        });

        pmPrev?.addEventListener('click', () => go(index - 1));
        pmNext?.addEventListener('click', () => go(index + 1));
        pmExpand?.addEventListener('click', openLightbox);
        pmImage?.addEventListener('click', openLightbox);

        lbPrev?.addEventListener('click', () => go(index - 1));
        lbNext?.addEventListener('click', () => go(index + 1));
        lightbox?.addEventListener('click', (e) => { if (e.target === lightbox) closeLightbox(); });

        document.querySelectorAll('[data-close-modal]').forEach((btn) => btn.addEventListener('click', closeModal));
        document.querySelectorAll('[data-close-lightbox]').forEach((btn) => btn.addEventListener('click', closeLightbox));

        // کیبورد: Esc برای بستن، فلش‌ها برای جابه‌جایی (در فارسی جهت فلش‌ها معکوس است)
        document.addEventListener('keydown', (e) => {
            const lbOpen = lightbox && !lightbox.classList.contains('hidden');
            const mOpen  = !modal.classList.contains('hidden');

            if (e.key === 'Escape') {
                if (lbOpen) closeLightbox();
                else if (mOpen) closeModal();
                return;
            }

            if (!mOpen) return;

            const back  = isFa ? 'ArrowRight' : 'ArrowLeft';
            const forth = isFa ? 'ArrowLeft'  : 'ArrowRight';

            if (e.key === back)  go(index - 1);
            if (e.key === forth) go(index + 1);
        });
    })();

    // توست فلش
    const toast = document.getElementById('flash-toast');
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-16px)';
            setTimeout(() => toast.remove(), 400);
        }, 4500);
    }
</script>
</body>
</html>
