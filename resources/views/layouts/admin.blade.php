<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت') | {{ \App\Models\Setting::current()->site_title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 700: '#182444', 800: '#111a2e', 900: '#0b1220', 950: '#070d1a' },
                        brand: { 50: '#f0fdfa', 100: '#ccfbf1', 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e' },
                    },
                    fontFamily: { sans: ['Vazirmatn', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>

    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style type="text/tailwindcss">
        .a-card    { @apply bg-white rounded-2xl shadow-sm border border-slate-200; }
        .a-input   { @apply w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15; }
        .a-label   { @apply block text-sm font-bold text-slate-700 mb-1.5; }
        .a-hint    { @apply text-xs text-slate-400 mt-1.5 leading-relaxed; }
        .a-error   { @apply text-xs text-red-500 mt-1 font-medium; }
        .a-btn     { @apply inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold transition select-none; }
        .a-btn-primary  { @apply a-btn bg-brand-600 text-white hover:bg-brand-700 shadow-sm shadow-brand-600/30; }
        .a-btn-ghost    { @apply a-btn bg-slate-100 text-slate-600 hover:bg-slate-200; }
        .a-btn-danger   { @apply a-btn bg-red-50 text-red-600 hover:bg-red-100 border border-red-200; }
        .a-badge   { @apply inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-bold; }
        .a-badge-on  { @apply a-badge bg-emerald-50 text-emerald-600 border border-emerald-200; }
        .a-badge-off { @apply a-badge bg-slate-100 text-slate-500 border border-slate-200; }
        .a-menu-link { @apply flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition; }
    </style>

    <style>
        /* اسکرول‌بار سفارشی */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }

        /* موبایل: سایدبار */
        @media (max-width: 1023px) {
            #a-sidebar { transform: translateX(100%); transition: transform .3s ease; }
            html[dir="rtl"] #a-sidebar.open { transform: translateX(0); }
        }
        @media (min-width: 1024px) {
            #a-sidebar { transform: none !important; }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">

@php
    $unreadCount = \App\Models\Message::unread()->count();
    $settingsTitle = \App\Models\Setting::current()->site_title;
@endphp

{{-- سایدبار --}}
<div id="a-backdrop" class="fixed inset-0 z-30 hidden bg-navy-950/60 backdrop-blur-sm lg:hidden"></div>

<aside id="a-sidebar" class="fixed inset-y-0 start-0 z-40 flex w-72 flex-col bg-navy-900 text-slate-300">
    {{-- لوگو --}}
    <div class="flex items-center gap-3 border-b border-white/10 px-6 py-5">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400 to-sky-500 text-lg font-black text-navy-950 shadow-lg shadow-brand-500/25">
            MY
        </div>
        <div>
            <p class="text-sm font-extrabold text-white">{{ $settingsTitle }}</p>
            <p class="text-[11px] text-slate-400">پنل مدیریت رزومه</p>
        </div>
    </div>

    {{-- منو --}}
    <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-5">
        <div>
            <a href="{{ route('admin.dashboard') }}"
               class="a-menu-link {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i> داشبورد
            </a>
        </div>

        <div>
            <p class="mb-2 px-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">مدیریت محتوا</p>
            <div class="space-y-1">
                <a href="{{ route('admin.personal-info.edit') }}"
                   class="a-menu-link {{ request()->routeIs('admin.personal-info.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-user-gear w-5 text-center"></i> اطلاعات شخصی
                </a>
                <a href="{{ route('admin.experiences.index') }}"
                   class="a-menu-link {{ request()->routeIs('admin.experiences.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-briefcase w-5 text-center"></i> تجربه‌های کاری
                </a>
                <a href="{{ route('admin.educations.index') }}"
                   class="a-menu-link {{ request()->routeIs('admin.educations.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-graduation-cap w-5 text-center"></i> تحصیلات
                </a>
                <a href="{{ route('admin.skills.index') }}"
                   class="a-menu-link {{ request()->routeIs('admin.skills.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-bolt w-5 text-center"></i> مهارت‌ها
                </a>
                <a href="{{ route('admin.portfolios.index') }}"
                   class="a-menu-link {{ request()->routeIs('admin.portfolios.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-folder-open w-5 text-center"></i> نمونه‌کارها
                </a>
                <a href="{{ route('admin.testimonials.index') }}"
                   class="a-menu-link {{ request()->routeIs('admin.testimonials.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-comment-dots w-5 text-center"></i> نظرات
                </a>
            </div>
        </div>

        <div>
            <p class="mb-2 px-4 text-[11px] font-bold uppercase tracking-wider text-slate-500">سیستم</p>
            <div class="space-y-1">
                <a href="{{ route('admin.messages.index') }}"
                   class="a-menu-link {{ request()->routeIs('admin.messages.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-envelope w-5 text-center"></i>
                    <span class="flex-1">پیام‌ها</span>
                    @if($unreadCount > 0)
                        <span class="rounded-full bg-brand-500 px-2 py-0.5 text-[11px] font-black text-navy-950">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.social-links.index') }}"
                   class="a-menu-link {{ request()->routeIs('admin.social-links.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-share-nodes w-5 text-center"></i> شبکه‌های اجتماعی
                </a>
                <a href="{{ route('admin.settings.edit') }}"
                   class="a-menu-link {{ request()->routeIs('admin.settings.*') ? 'bg-brand-600/15 text-brand-300' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fa-solid fa-gear w-5 text-center"></i> تنظیمات سایت
                </a>
            </div>
        </div>
    </nav>

    {{-- کاربر و خروج --}}
    <div class="border-t border-white/10 px-4 py-4">
        <div class="mb-3 flex items-center gap-3 px-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-sm font-bold text-white">
                {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                <p class="truncate text-[11px] text-slate-400">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="a-menu-link w-full text-slate-400 hover:bg-red-500/10 hover:text-red-400">
                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> خروج از حساب
            </button>
        </form>
    </div>
</aside>

{{-- محتوای اصلی --}}
<div class="lg:ps-72">
    {{-- توی‌بار --}}
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/80 backdrop-blur">
        <div class="flex items-center gap-4 px-5 py-3.5">
            <button id="a-burger" class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600 lg:hidden">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="flex-1 text-base font-extrabold text-slate-800">@yield('page-title', 'پنل مدیریت')</h1>
            <a href="{{ route('home', ['locale' => 'fa']) }}" target="_blank"
               class="a-btn-ghost !px-3.5 !py-2 text-xs">
                <i class="fa-solid fa-up-right-from-square"></i> مشاهده سایت
            </a>
        </div>
    </header>

    <main class="p-5 lg:p-8">
        {{-- پیام موفقیت --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-sm font-bold text-emerald-700">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- خطاهای اعتبارسنجی --}}
        @if($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="mb-2 flex items-center gap-2 font-black">
                    <i class="fa-solid fa-circle-exclamation"></i> خطاهای فرم:
                </p>
                <ul class="list-inside list-disc space-y-1 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    // سایدبار موبایل
    const sidebar = document.getElementById('a-sidebar');
    const backdrop = document.getElementById('a-backdrop');
    const burger = document.getElementById('a-burger');

    function toggleSidebar(force) {
        const open = force ?? !sidebar.classList.contains('open');
        sidebar.classList.toggle('open', open);
        backdrop.classList.toggle('hidden', !open);
    }

    burger?.addEventListener('click', () => toggleSidebar());
    backdrop?.addEventListener('click', () => toggleSidebar(false));

    // پیش‌نمایش تصویر قبل از آپلود
    document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
        input.addEventListener('change', () => {
            const target = document.getElementById(input.dataset.preview);
            if (target && input.files?.[0]) {
                target.src = URL.createObjectURL(input.files[0]);
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>
