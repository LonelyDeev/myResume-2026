{{-- ═════════════════════════════ نظرات کارفرماها ═════════════════════════════ --}}
@if ($settings->show_testimonials)
<section id="testimonials" class="relative bg-navy-950/40 py-24">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">
        <div class="mb-14 text-center" data-aos="fade-up">
            <span class="chip mb-4"><i class="fa-solid fa-comment-dots"></i> {{ __('app.sections.testimonials_kicker') }}</span>
            <h2 class="sec-title">{{ __('app.sections.testimonials_title') }}</h2>
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-l from-brand-400 to-sky-400"></div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($testimonials as $testimonial)
                <figure class="glass relative flex flex-col rounded-3xl p-7 transition hover:border-brand-400/30"
                        data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">

                    {{-- آیکن نقل‌قول --}}
                    <i class="fa-solid fa-quote-right absolute end-6 top-6 text-3xl text-brand-400/15"></i>

                    <div class="mb-5 flex gap-1 text-gold-400">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fa-solid fa-star text-xs"></i>
                        @endfor
                    </div>

                    <blockquote class="mb-6 flex-1 text-sm leading-8 text-slate-300">
                        {{ $testimonial->t('content') }}
                    </blockquote>

                    <figcaption class="flex items-center gap-3.5 border-t border-white/10 pt-5">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-brand-400/25 to-sky-500/25 text-base font-black text-brand-300">
                            @if ($testimonial->avatar_path)
                                <img src="{{ asset($testimonial->avatar_path) }}" alt="{{ $testimonial->t('name') }}" class="h-full w-full object-cover">
                            @else
                                {{ mb_substr($testimonial->t('name'), 0, 1) }}
                            @endif
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-black text-white">{{ $testimonial->t('name') }}</p>
                            @if ($testimonial->t('position'))
                                <p class="truncate text-xs text-slate-400">{{ $testimonial->t('position') }}</p>
                            @endif
                        </div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif
