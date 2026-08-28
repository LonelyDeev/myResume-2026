@extends('layouts.admin')

@section('title', $item->exists ? 'ویرایش لینک' : 'لینک جدید')
@section('page-title', $item->exists ? 'ویرایش لینک' : 'افزودن لینک')

@section('content')
    <form method="POST" action="{{ $item->exists ? route('admin.social-links.update', $item) : route('admin.social-links.store') }}" class="space-y-6">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        <div class="a-card p-6">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">نام پلتفرم <span class="text-red-500">*</span></label>
                    <input type="text" name="platform" value="{{ old('platform', $item->platform) }}" class="a-input" placeholder="مثال: تلگرام، لینکدین، گیت‌هاب" required>
                    @error('platform')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">آدرس لینک <span class="text-red-500">*</span></label>
                    <input type="text" name="url" dir="ltr" value="{{ old('url', $item->url) }}" class="a-input" placeholder="https://t.me/username یا mailto:you@mail.com" required>
                    @error('url')<p class="a-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="a-label">آیکون Font Awesome</label>
                    <input type="text" name="icon" dir="ltr" value="{{ old('icon', $item->icon) }}" class="a-input" placeholder="fa-brands fa-telegram">
                    <p class="a-hint">
                        نمونه‌ها: <span dir="ltr">fa-brands fa-linkedin</span> ، <span dir="ltr">fa-brands fa-github</span> ، <span dir="ltr">fa-solid fa-globe</span> ، <span dir="ltr">fa-solid fa-envelope</span>
                        <br>لیست کامل: <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" class="font-bold text-brand-600">fontawesome.com</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="a-card flex flex-wrap items-center justify-between gap-4 p-6">
            <div class="flex flex-wrap items-center gap-6">
                <label class="flex cursor-pointer items-center gap-2.5">
                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded accent-brand-600" {{ old('is_active', $item->exists ? $item->is_active : true) ? 'checked' : '' }}>
                    <span class="text-sm font-bold text-slate-700">فعال (نمایش در سایت)</span>
                </label>
                <div class="flex items-center gap-2">
                    <label class="text-sm font-bold text-slate-700">ترتیب:</label>
                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="a-input !w-24 !py-2 text-center">
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.social-links.index') }}" class="a-btn-ghost">انصراف</a>
                <button type="submit" class="a-btn-primary"><i class="fa-solid fa-floppy-disk"></i> ذخیره</button>
            </div>
        </div>
    </form>
@endsection
