{{-- ═════════════════════════════ درباره من ═════════════════════════════ --}}
@if ($settings->show_about)
<section id="about" class="relative py-24">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">
        {{-- عنوان سکشن --}}
        <div class="mb-14 text-center" data-aos="fade-up">
            <span class="chip mb-4"><i class="fa-solid fa-user-astronaut"></i> {{ __('app.sections.about_kicker') }}</span>
            <h2 class="sec-title">{{ __('app.sections.about_title') }}</h2>
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-l from-brand-400 to-sky-400"></div>
        </div>

        <div class="grid items-start gap-8 lg:grid-cols-5">
            {{-- بیوگرافی --}}
            <div class="glass rounded-3xl p-8 lg:col-span-3" data-aos="fade-up">
                <div class="mb-8 space-y-5 leading-8 text-slate-300 md:leading-9">
                    @foreach (preg_split('/\r\n|\r|\n/', $info->t('bio')) as $paragraph)
                        @if (trim($paragraph))
                            <p>{{ trim($paragraph) }}</p>
                        @endif
                    @endforeach
                </div>

                {{-- توانمندی‌های کلیدی --}}
                @if (count($info->abilitiesList()))
                    <h3 class="mb-5 flex items-center gap-2 text-sm font-black text-white">
                        <i class="fa-solid fa-gem text-brand-400"></i> {{ __('app.about.abilities_title') }}
                    </h3>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach ($info->abilitiesList() as $ability)
                            <span class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3.5 py-2 text-xs font-bold text-slate-300 transition hover:border-brand-400/40 hover:text-brand-300">
                                <i class="fa-solid fa-circle-check text-brand-400"></i>
                                {{ $ability }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- اطلاعات شخصی --}}
            <div class="glass rounded-3xl p-8 lg:col-span-2" data-aos="fade-up" data-aos-delay="150">
                <h3 class="mb-6 flex items-center gap-2 text-sm font-black text-white">
                    <i class="fa-solid fa-id-badge text-brand-400"></i> {{ __('app.about.info_title') }}
                </h3>

                <ul class="space-y-4">
                    @if ($info->birth_date || $info->birth_date_en)
                        <li class="flex items-center gap-4 rounded-2xl border border-white/5 bg-white/[0.03] px-4 py-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-400/10 text-brand-300">
                                <i class="fa-solid fa-cake-candles"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-500">{{ __('app.about.birth') }}</p>
                                <p class="truncate text-sm font-bold text-white">{{ app()->getLocale() === 'fa' ? $info->birth_date : ($info->birth_date_en ?: $info->birth_date) }}</p>
                            </div>
                        </li>
                    @endif

                    @if ($info->city)
                        <li class="flex items-center gap-4 rounded-2xl border border-white/5 bg-white/[0.03] px-4 py-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-400/10 text-brand-300">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-500">{{ __('app.about.location') }}</p>
                                <p class="truncate text-sm font-bold text-white">{{ $info->t('city') }}</p>
                            </div>
                        </li>
                    @endif

                    @if ($info->email)
                        <li class="flex items-center gap-4 rounded-2xl border border-white/5 bg-white/[0.03] px-4 py-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-400/10 text-brand-300">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-500">{{ __('app.about.email') }}</p>
                                <a href="mailto:{{ $info->email }}" dir="ltr" class="block truncate text-start text-sm font-bold text-white transition hover:text-brand-300">{{ $info->email }}</a>
                            </div>
                        </li>
                    @endif

                    @if ($info->phone)
                        <li class="flex items-center gap-4 rounded-2xl border border-white/5 bg-white/[0.03] px-4 py-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-400/10 text-brand-300">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-500">{{ __('app.about.phone') }}</p>
                                <a href="tel:{{ $info->phone }}" dir="ltr" class="block text-start text-sm font-bold text-white transition hover:text-brand-300">{{ $info->phone }}</a>
                            </div>
                        </li>
                    @endif

                    @if ($info->website)
                        <li class="flex items-center gap-4 rounded-2xl border border-white/5 bg-white/[0.03] px-4 py-3.5">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-400/10 text-brand-300">
                                <i class="fa-solid fa-globe"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-slate-500">{{ __('app.about.website') }}</p>
                                <a href="https://{{ preg_replace('#^https?://#', '', $info->website) }}" target="_blank" rel="noopener" dir="ltr" class="block truncate text-start text-sm font-bold text-white transition hover:text-brand-300">{{ $info->website }}</a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
@endif
