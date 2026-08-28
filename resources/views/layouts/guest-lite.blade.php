{{-- لایوت سبک برای صفحات Auth (لاگین، ثبت‌نام، بازیابی رمز) — سازگار با ساختار Breeze --}}
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ورود | پنل مدیریت</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 950: '#070d1a', 900: '#0b1220', 800: '#111a2e', 700: '#182444' },
                        brand: { 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488' },
                    },
                    fontFamily: { sans: ['Vazirmatn', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                }
            }
        }
    </script>

    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style type="text/tailwindcss">
        .glass   { @apply bg-white/[0.04] border border-white/10 backdrop-blur-xl; }
        .f-input { @apply w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-3.5 text-sm text-white placeholder-slate-500 outline-none transition focus:border-brand-400/60 focus:bg-white/[0.07] focus:ring-4 focus:ring-brand-400/10; }
        .f-btn-primary { @apply inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-l from-brand-500 to-sky-500 px-6 py-3 text-sm font-black text-navy-950 shadow-lg shadow-brand-500/30 transition hover:-translate-y-0.5 hover:shadow-brand-500/50; }
    </style>
</head>
<body class="relative min-h-screen bg-navy-900 font-sans text-slate-300 antialiased">

    {{-- افکت‌های پس‌زمینه --}}
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0"
             style="background-image: linear-gradient(rgba(148,163,184,.05) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,.05) 1px, transparent 1px); background-size: 44px 44px;"></div>
        <div class="absolute -top-32 -start-32 h-96 w-96 rounded-full bg-brand-500/15 blur-3xl"></div>
        <div class="absolute -bottom-32 -end-32 h-96 w-96 rounded-full bg-sky-500/10 blur-3xl"></div>
    </div>

    @yield('content')
</body>
</html>
