{{-- ═════════════════════════════ نمونه‌کارها ═════════════════════════════ --}}
@if ($settings->show_portfolios)
<section id="portfolios" class="relative py-24">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">
        <div class="mb-12 text-center" data-aos="fade-up">
            <span class="chip mb-4"><i class="fa-solid fa-folder-open"></i> {{ __('app.sections.portfolio_kicker') }}</span>
            <h2 class="sec-title">{{ __('app.sections.portfolio_title') }}</h2>
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-l from-brand-400 to-sky-400"></div>
        </div>

        {{-- فیلترها --}}
        @if (count($portfolioCategories) > 1)
            <div class="mb-10 flex flex-wrap items-center justify-center gap-2.5" data-aos="fade-up">
                <button type="button" data-filter="*"
                        class="portfolio-filter rounded-xl border px-4 py-2 text-xs font-black transition bg-brand-500 text-navy-950 border-brand-500">
                    {{ __('app.portfolio.all') }}
                </button>
                @foreach ($portfolioCategories as $category)
                    <button type="button" data-filter="{{ $category }}"
                            class="portfolio-filter rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-xs font-black text-slate-300 transition hover:text-brand-300">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- گرید کارت‌ها --}}
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($portfolios as $portfolio)
                <article class="portfolio-item glass group relative flex flex-col overflow-hidden rounded-3xl transition hover:border-brand-400/30 hover:shadow-2xl hover:shadow-brand-500/5"
                         data-category="{{ $portfolio->t('category') }}"
                         data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">

                    {{-- تصویر / گرادیان --}}
                    <button type="button" data-open class="relative block h-48 w-full overflow-hidden text-start" aria-label="{{ $portfolio->t('title') }}">
                        @if ($portfolio->image_path)
                            <img src="{{ Storage::url($portfolio->image_path) }}" alt="{{ $portfolio->t('title') }}"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute inset-0 bg-gradient-to-t from-navy-900 via-navy-900/30 to-transparent"></span>
                        @else
                            <span class="absolute inset-0 bg-gradient-to-br from-brand-600/80 via-navy-700 to-sky-700/70 transition duration-500 group-hover:scale-105"></span>
                            <span class="absolute inset-0 opacity-20 bg-grid"></span>
                            <span class="absolute bottom-4 start-6 text-7xl font-black text-white/25">{{ $portfolio->initial() }}</span>
                        @endif

                        {{-- نشان شاخص --}}
                        @if ($portfolio->is_featured)
                            <span class="absolute top-4 start-4 rounded-full bg-gold-500/90 px-3 py-1 text-[11px] font-black text-navy-950 shadow-lg">
                                <i class="fa-solid fa-star text-[9px]"></i> {{ __('app.portfolio.featured') }}
                            </span>
                        @endif

                        {{-- آیکن مشاهده در هاور --}}
                        <span class="absolute inset-0 flex items-center justify-center opacity-0 transition duration-300 group-hover:opacity-100">
                            <span class="flex h-14 w-14 items-center justify-center rounded-full border border-white/30 bg-navy-950/60 text-white backdrop-blur">
                                <i class="fa-solid fa-plus"></i>
                            </span>
                        </span>
                    </button>

                    {{-- بدنه کارت --}}
                    <div class="flex flex-1 flex-col p-6">
                        @if ($portfolio->t('category'))
                            <span class="mb-2 text-[11px] font-black uppercase tracking-wider text-brand-300">{{ $portfolio->t('category') }}</span>
                        @endif

                        <h3 class="mb-2.5 text-lg font-black leading-7 text-white">{{ $portfolio->t('title') }}</h3>
                        <p class="mb-5 text-sm leading-7 text-slate-400">{{ $portfolio->excerpt() }}</p>

                        {{-- تگ‌های تکنولوژی --}}
                        @if (count($portfolio->techs()))
                            <div class="mb-5 flex flex-wrap gap-1.5">
                                @foreach (array_slice($portfolio->techs(), 0, 4) as $tech)
                                    <span class="tech-tag">{{ $tech }}</span>
                                @endforeach
                                @if (count($portfolio->techs()) > 4)
                                    <span class="tech-tag">+{{ count($portfolio->techs()) - 4 }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="mt-auto flex items-center gap-3">
                            <button type="button" data-open class="text-xs font-black text-brand-300 transition hover:text-white">
                                {{ __('app.portfolio.details') }} <i class="fa-solid fa-angle-{{ app()->getLocale() === 'fa' ? 'left' : 'right' }}"></i>
                            </button>
                            @if ($portfolio->url)
                                <a href="{{ $portfolio->url }}" target="_blank" rel="noopener"
                                   class="ms-auto flex h-8 w-8 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-xs text-slate-400 transition hover:border-brand-400/40 hover:text-brand-300"
                                   title="{{ __('app.portfolio.visit') }}">
                                    <i class="fa-solid fa-up-right-from-square"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- داده مودال --}}
                    <template class="portfolio-data">
                        <div class="mb-1 text-xs font-black uppercase tracking-wider text-brand-300">{{ $portfolio->t('category') }}</div>
                        <h3 class="mb-4 text-2xl font-black text-white">{{ $portfolio->t('title') }}</h3>

                        <div class="mb-6 space-y-5 leading-8 text-slate-300">
                            @foreach (preg_split('/\r\n|\r|\n/', $portfolio->t('description')) as $paragraph)
                                @if (trim($paragraph))
                                    <p>{{ trim($paragraph) }}</p>
                                @endif
                            @endforeach
                        </div>

                        @if ($portfolio->t('client'))
                            <p class="mb-4 text-sm font-bold text-slate-400">
                                <i class="fa-solid fa-user-tie me-2 text-brand-400"></i>{{ __('app.portfolio.client') }}: {{ $portfolio->t('client') }}
                            </p>
                        @endif

                        @if (count($portfolio->techs()))
                            <div class="mb-6 flex flex-wrap gap-2">
                                @foreach ($portfolio->techs() as $tech)
                                    <span class="tech-tag !px-3 !py-1.5 text-xs">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($portfolio->url)
                            <a href="{{ $portfolio->url }}" target="_blank" rel="noopener" class="f-btn-primary !py-2.5 !text-xs">
                                <i class="fa-solid fa-up-right-from-square"></i> {{ __('app.portfolio.visit') }}
                            </a>
                        @endif
                    </template>
                </article>
            @endforeach
        </div>
    </div>

    {{-- مودال جزئیات --}}
    <div id="portfolio-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto bg-navy-950/80 p-4 backdrop-blur-md md:p-8">
        <div class="glass relative mx-auto max-w-2xl rounded-3xl bg-navy-800/95 p-8 shadow-2xl">
            <button type="button" data-close-modal
                    class="absolute end-5 top-5 flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-slate-400 transition hover:border-red-400/40 hover:text-red-400"
                    aria-label="{{ __('app.portfolio.close') }}">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div id="modal-content"></div>
        </div>
    </div>
</section>
@endif
