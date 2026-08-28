{{-- ═════════════════════════════ تماس با من ═════════════════════════════ --}}
@if ($settings->show_contact)
<section id="contact" class="relative py-24">
    {{-- افکت پس‌زمینه --}}
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute bottom-0 start-1/4 h-72 w-72 rounded-full bg-brand-500/10 blur-3xl"></div>
        <div class="absolute bottom-0 end-1/4 h-72 w-72 rounded-full bg-sky-500/10 blur-3xl"></div>
    </div>

    <div class="mx-auto max-w-6xl px-5 lg:px-8">
        <div class="mb-14 text-center" data-aos="fade-up">
            <span class="chip mb-4"><i class="fa-solid fa-paper-plane"></i> {{ __('app.sections.contact_kicker') }}</span>
            <h2 class="sec-title">{{ __('app.sections.contact_title') }}</h2>
            <div class="mx-auto mt-4 h-1 w-20 rounded-full bg-gradient-to-l from-brand-400 to-sky-400"></div>
        </div>

        <div class="grid items-start gap-8 lg:grid-cols-5">
            {{-- راه‌های ارتباطی --}}
            <div class="space-y-4 lg:col-span-2" data-aos="fade-up">
                <p class="mb-2 text-sm leading-8 text-slate-400">{{ $settings->t('contact_intro') }}</p>

                @if ($info->email)
                    <a href="mailto:{{ $info->email }}" class="glass flex items-center gap-4 rounded-2xl p-5 transition hover:border-brand-400/30 hover:bg-white/[0.06]">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400/20 to-sky-500/20 text-brand-300">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-500">{{ __('app.about.email') }}</p>
                            <p dir="ltr" class="truncate text-start text-sm font-bold text-white">{{ $info->email }}</p>
                        </div>
                    </a>
                @endif

                @if ($info->phone)
                    <a href="tel:{{ $info->phone }}" class="glass flex items-center gap-4 rounded-2xl p-5 transition hover:border-brand-400/30 hover:bg-white/[0.06]">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400/20 to-sky-500/20 text-brand-300">
                            <i class="fa-solid fa-phone"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-500">{{ __('app.about.phone') }}</p>
                            <p dir="ltr" class="text-start text-sm font-bold text-white">{{ $info->phone }}</p>
                        </div>
                    </a>
                @endif

                @if ($info->telegram)
                    <a href="https://t.me/{{ $info->telegram }}" target="_blank" rel="noopener" class="glass flex items-center gap-4 rounded-2xl p-5 transition hover:border-brand-400/30 hover:bg-white/[0.06]">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400/20 to-sky-500/20 text-brand-300">
                            <i class="fa-brands fa-telegram"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-500">Telegram</p>
                            <p dir="ltr" class="text-start text-sm font-bold text-white">{{ '@'.$info->telegram }}</p>
                        </div>
                    </a>
                @endif

                @if ($info->city)
                    <div class="glass flex items-center gap-4 rounded-2xl p-5">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-400/20 to-sky-500/20 text-brand-300">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-slate-500">{{ __('app.about.location') }}</p>
                            <p class="text-sm font-bold text-white">{{ $info->t('city') }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- فرم تماس --}}
            <div class="glass rounded-3xl p-8 lg:col-span-3" data-aos="fade-up" data-aos-delay="150">
                <form method="POST" action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" class="space-y-5">
                    @csrf

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-xs font-black text-slate-400">{{ __('app.contact.name') }} <span class="text-brand-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="f-input {{ $errors->has('name') ? '!border-red-400/60' : '' }}"
                                   placeholder="{{ __('app.contact.name_placeholder') }}">
                        </div>
                        <div>
                            <label class="mb-2 block text-xs font-black text-slate-400">{{ __('app.contact.email') }} <span class="text-brand-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" dir="ltr" required
                                   class="f-input {{ $errors->has('email') ? '!border-red-400/60' : '' }}"
                                   placeholder="you@example.com">
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-400">{{ __('app.contact.subject') }}</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="f-input"
                               placeholder="{{ __('app.contact.subject_placeholder') }}">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-black text-slate-400">{{ __('app.contact.message') }} <span class="text-brand-400">*</span></label>
                        <textarea name="message" rows="5" required
                                  class="f-input resize-none {{ $errors->has('message') ? '!border-red-400/60' : '' }}"
                                  placeholder="{{ __('app.contact.message_placeholder') }}">{{ old('message') }}</textarea>
                    </div>

                    @error('message')
                        <p class="text-xs font-bold text-red-400"><i class="fa-solid fa-circle-exclamation me-1.5"></i>{{ $message }}</p>
                    @enderror

                    <button type="submit" class="f-btn-primary w-full md:w-auto">
                        <i class="fa-solid fa-paper-plane"></i> {{ __('app.contact.send') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endif
