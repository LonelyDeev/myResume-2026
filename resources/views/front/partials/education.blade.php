{{-- ═════════════════════════════ تحصیلات ═════════════════════════════ --}}
@if ($settings->show_education)
<section id="education" class="relative py-24">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">
        <div class="mb-14 text-center" data-aos="fade-up">
            <span class="chip mb-4"><i class="fa-solid fa-graduation-cap"></i> {{ __('app.sections.education_kicker') }}</span>
            <h2 class="sec-title">{{ __('app.sections.education_title') }}</h2>
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-l from-brand-400 to-sky-400"></div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @foreach ($educations as $education)
                <div class="glass group relative overflow-hidden rounded-3xl p-7 transition hover:border-brand-400/30 hover:bg-white/[0.06]"
                     data-aos="fade-up" data-aos-delay="{{ ($loop->index % 2) * 100 }}">
                    {{-- خط تزئینی کنار کارت --}}
                    <span class="absolute inset-y-0 start-0 w-1 bg-gradient-to-b from-brand-400 to-sky-500 opacity-0 transition group-hover:opacity-100"></span>

                    <div class="mb-5 flex items-start justify-between gap-4">
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-400/20 to-sky-500/20 text-xl text-brand-300 transition group-hover:scale-110">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                        @if ($education->period)
                            <span class="rounded-xl border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-bold text-brand-300">
                                {{ $education->t('period') }}
                            </span>
                        @endif
                    </div>

                    <h3 class="mb-2 text-lg font-black text-white">{{ $education->t('degree') }}</h3>
                    <p class="mb-3 flex items-center gap-2 text-sm font-bold text-slate-400">
                        <i class="fa-solid fa-school text-brand-400/70"></i>
                        {{ $education->t('institution') }}
                    </p>

                    @if ($education->t('description'))
                        <p class="text-sm leading-7 text-slate-400">{{ $education->t('description') }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
