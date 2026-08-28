{{-- ═════════════════════════════ مهارت‌ها ═════════════════════════════ --}}
@if ($settings->show_skills)
@php
    $skillIcons = [
        'fa-solid fa-code', 'fa-solid fa-layer-group', 'fa-solid fa-database',
        'fa-solid fa-robot', 'fa-solid fa-shield-halved', 'fa-solid fa-language',
        'fa-solid fa-screwdriver-wrench', 'fa-solid fa-palette',
    ];
@endphp

<section id="skills" class="relative bg-navy-950/40 py-24">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">
        <div class="mb-14 text-center" data-aos="fade-up">
            <span class="chip mb-4"><i class="fa-solid fa-bolt"></i> {{ __('app.sections.skills_kicker') }}</span>
            <h2 class="sec-title">{{ __('app.sections.skills_title') }}</h2>
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-l from-brand-400 to-sky-400"></div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($skills as $category => $items)
                <div class="glass rounded-3xl p-7 transition hover:border-brand-400/30"
                     data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">
                    <h3 class="mb-6 flex items-center gap-3 text-base font-black text-white">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400/20 to-sky-500/20 text-brand-300">
                            <i class="{{ $skillIcons[$loop->index % count($skillIcons)] }}"></i>
                        </span>
                        {{ $category }}
                    </h3>

                    <div class="space-y-4">
                        @foreach ($items as $skill)
                            @if (!is_null($skill->level))
                                {{-- نوار پیشرفت --}}
                                <div>
                                    <div class="mb-1.5 flex items-center justify-between text-xs font-bold">
                                        <span class="text-slate-300">{{ $skill->t('name') }}</span>
                                        <span class="text-brand-300">{{ $skill->level }}{{ app()->getLocale() === 'fa' ? '٪' : '%' }}</span>
                                    </div>
                                    <div class="h-2 overflow-hidden rounded-full bg-white/10">
                                        <div class="skill-bar-fill h-full w-0 rounded-full bg-gradient-to-l from-brand-400 to-sky-400 transition-all duration-1000"
                                             data-level="{{ $skill->level }}"></div>
                                    </div>
                                </div>
                            @else
                                {{-- تگ مهارت --}}
                                <span class="inline-flex me-2 items-center rounded-xl border border-white/10 bg-white/5 px-3.5 py-2 text-xs font-bold text-slate-300 transition hover:border-brand-400/40 hover:text-brand-300">
                                    {{ $skill->t('name') }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
