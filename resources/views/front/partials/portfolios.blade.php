{{-- ═════════════════════════════ نمونه‌کارها ═════════════════════════════ --}}
@if ($settings->show_portfolios)
@php
    $isRtl = app()->getLocale() === 'fa';

    // تبدیل ارقام شمارنده‌ها به فارسی
    $faNum = fn ($value) => $isRtl
        ? strtr((string) $value, ['0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹'])
        : (string) $value;
@endphp
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
                @php $galleryUrls = $portfolio->galleryUrls(); @endphp
                <article class="portfolio-item glass group relative flex flex-col overflow-hidden rounded-3xl transition hover:border-brand-400/30 hover:shadow-2xl hover:shadow-brand-500/5"
                         data-category="{{ $portfolio->t('category') }}"
                         data-gallery='@json($galleryUrls)'
                         data-title="{{ $portfolio->t('title') }}"
                         data-initial="{{ $portfolio->initial() }}"
                         data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 90 }}">

                    {{-- تصویر / گرادیان --}}
                    <button type="button" data-open class="relative block h-48 w-full overflow-hidden text-start" aria-label="{{ $portfolio->t('title') }}">
                        @if ($portfolio->coverUrl())
                            <img src="{{ $portfolio->coverUrl() }}" alt="{{ $portfolio->t('title') }}"
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

                        {{-- تعداد تصاویر گالری --}}
                        @if (count($galleryUrls) > 1)
                            <span class="absolute top-4 end-4 flex items-center gap-1.5 rounded-full bg-navy-950/75 px-3 py-1 text-[11px] font-black text-white shadow-lg backdrop-blur">
                                <i class="fa-solid fa-images text-[10px] text-brand-300"></i>
                                {{ $faNum(__('app.portfolio.photos_count', ['count' => count($galleryUrls)])) }}
                            </span>
                        @endif

                        {{-- آیکن مشاهده در هاور --}}
                        <span class="absolute inset-0 flex items-center justify-center opacity-0 transition duration-300 group-hover:opacity-100">
                            <span class="flex h-14 w-14 items-center justify-center rounded-full border border-white/30 bg-navy-950/60 text-white backdrop-blur transition group-hover:rotate-90">
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
                                    <span class="tech-tag">+{{ $faNum(count($portfolio->techs()) - 4) }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="mt-auto flex items-center gap-3">
                            <button type="button" data-open class="text-xs font-black text-brand-300 transition hover:text-white">
                                {{ __('app.portfolio.details') }} <i class="fa-solid fa-angle-{{ $isRtl ? 'left' : 'right' }}"></i>
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

                    {{-- داده مودال (پنل جزئیات) --}}
                    <template class="portfolio-data">
                        <div class="mb-1.5 text-[11px] font-black uppercase tracking-wider text-brand-300">{{ $portfolio->t('category') }}</div>
                        <h3 class="mb-5 text-2xl font-black leading-9 text-white">{{ $portfolio->t('title') }}</h3>

                        <div class="mb-6 space-y-4 leading-8 text-slate-300">
                            @foreach (preg_split('/\r\n|\r|\n/', $portfolio->t('description')) as $paragraph)
                                @if (trim($paragraph))
                                    <p>{{ trim($paragraph) }}</p>
                                @endif
                            @endforeach
                        </div>

                        @if ($portfolio->t('client'))
                            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-400/10 text-brand-300">
                                    <i class="fa-solid fa-user-tie"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold text-slate-500">{{ __('app.portfolio.client') }}</p>
                                    <p class="truncate text-sm font-bold text-white">{{ $portfolio->t('client') }}</p>
                                </div>
                            </div>
                        @endif

                        @if (count($portfolio->techs()))
                            <div class="mb-7 flex flex-wrap gap-2">
                                @foreach ($portfolio->techs() as $tech)
                                    <span class="tech-tag !px-3 !py-1.5 text-xs">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if ($portfolio->url)
                            <a href="{{ $portfolio->url }}" target="_blank" rel="noopener"
                               class="f-btn-primary w-full !py-3 !text-xs">
                                <i class="fa-solid fa-up-right-from-square"></i> {{ __('app.portfolio.visit') }}
                            </a>
                        @endif
                    </template>
                </article>
            @endforeach
        </div>
    </div>

    {{-- ═══════════ مودال جزئیات + گالری ═══════════ --}}
    <div id="portfolio-modal" class="fixed inset-0 z-[60] hidden overflow-y-auto bg-navy-950/85 p-4 backdrop-blur-md md:p-8">
        <div class="flex min-h-full justify-center">
            <div class="pm-shell relative my-auto w-full max-w-5xl overflow-hidden rounded-[2rem] border border-white/10 bg-navy-800/95 shadow-2xl shadow-black/60">

                {{-- هاله نور تزئینی --}}
                <div class="pointer-events-none absolute -top-40 start-1/2 z-0 h-72 w-[30rem] -translate-x-1/2 rounded-full bg-brand-500/10 blur-3xl"></div>

                {{-- دکمه بستن --}}
                <button type="button" data-close-modal
                        class="absolute end-4 top-4 z-20 flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-navy-950/70 text-slate-300 backdrop-blur transition hover:border-red-400/50 hover:text-red-400"
                        aria-label="{{ __('app.portfolio.close') }}">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <div class="relative grid lg:grid-cols-[7fr_5fr]">
                    {{-- ═══ پنل گالری ═══ --}}
                    <div class="relative flex flex-col gap-4 p-5 pb-6 lg:p-7">
                        {{-- اسلاید اصلی --}}
                        <div class="group/stage relative aspect-[16/10] w-full overflow-hidden rounded-2xl border border-white/10 bg-navy-950">
                            <img id="pm-image" src="" alt="" class="h-full w-full cursor-zoom-in object-cover opacity-0 transition-opacity duration-300">

                            {{-- جایگزین گرادیانی وقتی تصویری وجود ندارد --}}
                            <div id="pm-placeholder" class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-brand-600/80 via-navy-700 to-sky-700/70">
                                <span class="absolute inset-0 opacity-20 bg-grid"></span>
                                <span id="pm-initial" class="text-8xl font-black text-white/25">M</span>
                            </div>

                            {{-- دکمه قبلی / بعدی --}}
                            <button type="button" id="pm-prev" aria-label="{{ __('app.portfolio.prev') }}"
                                    class="absolute start-3 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 flex items-center justify-center rounded-full border border-white/15 bg-navy-950/60 text-sm text-white backdrop-blur transition hover:border-brand-400/60 hover:bg-navy-950/85 hover:text-brand-300">
                                <i class="fa-solid fa-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
                            </button>
                            <button type="button" id="pm-next" aria-label="{{ __('app.portfolio.next') }}"
                                    class="absolute end-3 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 flex items-center justify-center rounded-full border border-white/15 bg-navy-950/60 text-sm text-white backdrop-blur transition hover:border-brand-400/60 hover:bg-navy-950/85 hover:text-brand-300">
                                <i class="fa-solid fa-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                            </button>

                            {{-- شمارنده تصاویر --}}
                            <div id="pm-counter" class="absolute bottom-3 start-3 hidden rounded-full bg-navy-950/75 px-3.5 py-1.5 text-[11px] font-black tracking-wide text-white backdrop-blur">—</div>

                            {{-- نمای تمام‌صفحه --}}
                            <button type="button" id="pm-expand" title="{{ __('app.portfolio.view_fullsize') }}"
                                    class="absolute bottom-3 end-3 hidden h-9 w-9 flex items-center justify-center rounded-full border border-white/15 bg-navy-950/60 text-xs text-white backdrop-blur transition hover:border-brand-400/60 hover:text-brand-300">
                                <i class="fa-solid fa-expand"></i>
                            </button>
                        </div>

                        {{-- بندانگشتی‌ها --}}
                        <div id="pm-thumbs" class="pm-thumbs hidden gap-2.5 overflow-x-auto pb-1"></div>
                    </div>

                    {{-- ═══ پنل جزئیات ═══ --}}
                    <div class="relative border-t border-white/10 lg:border-s lg:border-t-0 lg:border-white/10">
                        <div id="pm-details" class="pm-details p-6 lg:max-h-[82vh] lg:overflow-y-auto lg:p-8"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════ لایت‌باکس تمام‌صفحه ═══════════ --}}
    <div id="portfolio-lightbox" class="fixed inset-0 z-[80] hidden bg-black/95 p-4 backdrop-blur-sm md:p-14">
        <button type="button" data-close-lightbox
                class="absolute end-5 top-5 z-20 flex h-11 w-11 items-center justify-center rounded-xl border border-white/15 bg-white/5 text-slate-300 transition hover:border-red-400/50 hover:text-red-400"
                aria-label="{{ __('app.portfolio.close') }}">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <button type="button" id="lb-prev" aria-label="{{ __('app.portfolio.prev') }}"
                class="absolute start-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 flex items-center justify-center rounded-full border border-white/15 bg-white/5 text-white backdrop-blur transition hover:border-brand-400/60 hover:text-brand-300 md:start-8">
            <i class="fa-solid fa-chevron-{{ $isRtl ? 'right' : 'left' }}"></i>
        </button>

        <img id="lb-image" src="" alt="" class="absolute inset-0 m-auto max-h-full max-w-full rounded-xl object-contain shadow-2xl">

        <button type="button" id="lb-next" aria-label="{{ __('app.portfolio.next') }}"
                class="absolute end-4 top-1/2 z-20 hidden h-12 w-12 -translate-y-1/2 flex items-center justify-center rounded-full border border-white/15 bg-white/5 text-white backdrop-blur transition hover:border-brand-400/60 hover:text-brand-300 md:end-8">
            <i class="fa-solid fa-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
        </button>

        <div id="lb-counter" class="absolute bottom-6 start-1/2 hidden -translate-x-1/2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-black tracking-widest text-white backdrop-blur">—</div>
    </div>
</section>
@endif
