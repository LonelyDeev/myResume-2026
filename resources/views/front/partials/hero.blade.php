{{-- ═════════════════════════════ HERO ═════════════════════════════ --}}
<section id="hero" class="relative flex min-h-screen items-center overflow-hidden pt-28 pb-16">
    {{-- افکت‌های پس‌زمینه --}}
    <div class="absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-grid"></div>
        <div class="absolute -top-40 -start-40 h-[30rem] w-[30rem] rounded-full bg-brand-500/15 blur-3xl"></div>
        <div class="absolute top-1/3 -end-40 h-[26rem] w-[26rem] rounded-full bg-sky-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 start-1/3 h-[20rem] w-[20rem] rounded-full bg-gold-500/5 blur-3xl"></div>
    </div>

    <div class="mx-auto grid w-full max-w-6xl items-center gap-14 px-5 lg:grid-cols-5 lg:px-8">
        {{-- متن معرفی --}}
        <div class="lg:col-span-3" data-aos="fade-up">
            <p class="chip mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-400 opacity-75"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-brand-400"></span>
                </span>
                {{ __('app.hero.available') }}
            </p>

            <h1 class="mb-4 text-4xl font-black leading-tight text-white md:text-5xl lg:text-6xl">
                {{ $info->t('name') }}
            </h1>

            <h2 class="mb-6 flex flex-wrap items-center gap-x-3 text-xl font-extrabold text-slate-400 md:text-2xl">
                <span id="typing-text" class="bg-gradient-to-l from-brand-300 to-sky-400 bg-clip-text text-transparent"></span>
                <span class="typing-cursor"></span>
            </h2>

            <p class="mb-9 max-w-xl text-base leading-8 text-slate-400 md:text-lg md:leading-9">
                {{ $info->t('tagline') }}
            </p>

            <div class="mb-10 flex flex-wrap items-center gap-4">
                @if ($settings->show_portfolios)
                    <a href="#portfolios" class="f-btn-primary">
                        <i class="fa-solid fa-layer-group"></i> {{ __('app.hero.view_portfolio') }}
                    </a>
                @endif

                @if ($info->cv_path)
                    <a href="{{ asset($info->cv_path) }}" download class="f-btn-ghost">
                        <i class="fa-solid fa-file-arrow-down text-brand-400"></i> {{ __('app.hero.download_cv') }}
                    </a>
                @endif

                @if ($settings->show_contact)
                    <a href="#contact" class="f-btn-ghost">
                        <i class="fa-solid fa-paper-plane text-brand-400"></i> {{ __('app.hero.contact_me') }}
                    </a>
                @endif
            </div>

            {{-- شبکه‌های اجتماعی --}}
            <div class="flex items-center gap-3">
                @foreach ($socials as $social)
                    <a href="{{ $social->url }}" target="_blank" rel="noopener" title="{{ $social->platform }}"
                       class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-slate-400 transition hover:-translate-y-1 hover:border-brand-400/50 hover:text-brand-300">
                        <i class="{{ $social->icon }}"></i>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- آواتار --}}
        <div class="relative mx-auto lg:col-span-2" data-aos="fade-left" data-aos-delay="200">
            <div class="relative mx-auto h-64 w-64 md:h-80 md:w-80">
                {{-- حلقه گرادیانی چرخان --}}
                <div class="absolute -inset-3 rounded-full bg-[conic-gradient(from_0deg,#14b8a6,#38bdf8,#f59e0b,#14b8a6)] opacity-70 blur-md" style="animation: spin 8s linear infinite;"></div>
                <div class="absolute -inset-3 rounded-full bg-navy-900"></div>

                <div class="relative h-full w-full overflow-hidden rounded-full border-4 border-navy-800 bg-navy-800 shadow-2xl">
                    @if ($info->avatar_path)
                        <img src="{{ asset($info->avatar_path) }}" alt="{{ $info->t('name') }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-navy-700 to-navy-950">
                            <span class="bg-gradient-to-l from-brand-300 to-sky-400 bg-clip-text text-8xl font-black text-transparent">
                                {{ mb_substr($info->t('name'), 0, 1) }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- نشان‌های شناور --}}
            <div class="glass absolute -start-6 top-8 flex animate-float items-center gap-2.5 rounded-2xl px-4 py-3 shadow-xl">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <i class="fa-brands fa-laravel text-lg"></i>
                </span>
                <div>
                    <p class="text-xs font-black text-white">Laravel</p>
                    <p class="text-[10px] text-slate-400">Expert</p>
                </div>
            </div>

            <div class="glass absolute -end-4 bottom-10 flex animate-float-slow items-center gap-2.5 rounded-2xl px-4 py-3 shadow-xl">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-400/15 text-brand-300">
                    <i class="fa-solid fa-code text-sm"></i>
                </span>
                <div>
                    <p class="text-xs font-black text-white">+5 {{ __('app.hero.years') }}</p>
                    <p class="text-[10px] text-slate-400">{{ __('app.hero.experience') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- نشانگر اسکرول --}}
    <a href="#about" class="absolute bottom-7 start-1/2 hidden -translate-x-1/2 flex-col items-center gap-2 text-slate-500 transition hover:text-brand-300 md:flex">
        <span class="text-[10px] font-bold tracking-widest">{{ __('app.hero.scroll') }}</span>
        <span class="flex h-9 w-6 justify-center rounded-full border-2 border-current p-1">
            <span class="h-2 w-1 animate-bounce rounded-full bg-current"></span>
        </span>
    </a>
</section>
