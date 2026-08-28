{{-- ═════════════════════════════ تجربه کاری ═════════════════════════════ --}}
@if ($settings->show_experience)
<section id="experience" class="relative bg-navy-950/40 py-24">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">
        <div class="mb-14 text-center" data-aos="fade-up">
            <span class="chip mb-4"><i class="fa-solid fa-briefcase"></i> {{ __('app.sections.experience_kicker') }}</span>
            <h2 class="sec-title">{{ __('app.sections.experience_title') }}</h2>
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-l from-brand-400 to-sky-400"></div>
        </div>

        <ol class="relative ms-3 space-y-8 border-s border-white/10 md:ms-6">
            @foreach ($experiences as $experience)
                <li class="relative ps-8 md:ps-12" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                    {{-- نقطه تایم‌لاین --}}
                    <span class="absolute top-1.5 -start-[7px] flex h-3.5 w-3.5 items-center justify-center">
                        <span class="absolute h-full w-full rounded-full {{ $experience->is_current ? 'bg-brand-400' : 'bg-slate-600' }}"></span>
                        @if ($experience->is_current)
                            <span class="absolute h-full w-full animate-ping rounded-full bg-brand-400 opacity-60"></span>
                        @endif
                    </span>

                    <div class="glass group rounded-3xl p-7 transition hover:border-brand-400/30 hover:bg-white/[0.06] md:p-8">
                        <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h3 class="mb-1.5 flex flex-wrap items-center gap-3 text-lg font-black text-white md:text-xl">
                                    {{ $experience->t('position') }}
                                    @if ($experience->is_current)
                                        <span class="rounded-full bg-brand-400/15 px-3 py-1 text-[11px] font-black text-brand-300">
                                            <i class="fa-solid fa-circle-dot text-[8px]"></i> {{ __('app.experience.current') }}
                                        </span>
                                    @endif
                                </h3>
                                <p class="flex items-center gap-2 text-sm font-bold text-slate-400">
                                    <i class="fa-solid fa-building text-brand-400/70"></i>
                                    {{ $experience->t('company') }}
                                </p>
                            </div>
                            <span class="rounded-xl border border-white/10 bg-white/5 px-3.5 py-1.5 text-xs font-bold text-brand-300">
                                {{ $experience->t('period') }}
                            </span>
                        </div>

                        @if (count($experience->bullets()))
                            <ul class="space-y-2.5">
                                @foreach ($experience->bullets() as $bullet)
                                    <li class="flex items-start gap-2.5 text-sm leading-7 text-slate-300">
                                        <i class="fa-solid fa-circle-check mt-1.5 text-sm text-brand-400/80"></i>
                                        <span>{{ $bullet }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
@endif
