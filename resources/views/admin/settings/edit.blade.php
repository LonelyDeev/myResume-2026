@extends('layouts.admin')

@section('title', 'تنظیمات سایت')
@section('page-title', 'تنظیمات سایت')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- عمومی --}}
        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-globe text-brand-600"></i> عمومی و سئو
            </h3>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">عنوان سایت (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="site_title" value="{{ old('site_title', $settings->site_title) }}" class="a-input" required>
                    @error('site_title')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Site Title (English)</label>
                    <input type="text" name="site_title_en" dir="ltr" value="{{ old('site_title_en', $settings->site_title_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">توضیحات متا (فارسی)</label>
                    <textarea name="meta_description" rows="3" class="a-input">{{ old('meta_description', $settings->meta_description) }}</textarea>
                </div>
                <div>
                    <label class="a-label">Meta Description (English)</label>
                    <textarea name="meta_description_en" dir="ltr" rows="3" class="a-input">{{ old('meta_description_en', $settings->meta_description_en) }}</textarea>
                </div>

                <div>
                    <label class="a-label">متن فوتر (فارسی)</label>
                    <input type="text" name="footer_text" value="{{ old('footer_text', $settings->footer_text) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">Footer Text (English)</label>
                    <input type="text" name="footer_text_en" dir="ltr" value="{{ old('footer_text_en', $settings->footer_text_en) }}" class="a-input">
                </div>
            </div>
        </div>

        {{-- سکشن تماس --}}
        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-paper-plane text-brand-600"></i> سکشن تماس
            </h3>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">متن معرفی (فارسی)</label>
                    <textarea name="contact_intro" rows="3" class="a-input">{{ old('contact_intro', $settings->contact_intro) }}</textarea>
                </div>
                <div>
                    <label class="a-label">Contact Intro (English)</label>
                    <textarea name="contact_intro_en" dir="ltr" rows="3" class="a-input">{{ old('contact_intro_en', $settings->contact_intro_en) }}</textarea>
                </div>
            </div>
        </div>

        {{-- نمایش سکشن‌ها --}}
        <div class="a-card p-6">
            <h3 class="mb-2 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-eye text-brand-600"></i> نمایش سکشن‌های صفحه اصلی
            </h3>
            <p class="mb-5 text-xs text-slate-400">سکشن‌های غیرفعال به‌طور کامل از صفحه اصلی حذف می‌شوند و منوی اسکرول هم آپدیت می‌شود.</p>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    'show_about'        => 'درباره من',
                    'show_experience'   => 'تجربه‌های کاری',
                    'show_education'    => 'تحصیلات',
                    'show_skills'       => 'مهارت‌ها',
                    'show_portfolios'   => 'نمونه‌کارها',
                    'show_testimonials' => 'نظرات کارفرماها',
                    'show_contact'      => 'تماس با من',
                ] as $key => $label)
                    <label class="flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 transition hover:border-brand-300">
                        <span class="text-sm font-bold text-slate-700">{{ $label }}</span>
                        <input type="checkbox" name="{{ $key }}" value="1" class="h-5 w-5 rounded accent-brand-600" {{ old($key, $settings->{$key}) ? 'checked' : '' }}>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="a-btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> ذخیره تنظیمات
            </button>
        </div>
    </form>
@endsection
