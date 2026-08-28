@extends('layouts.admin')

@section('title', $item->exists ? 'ویرایش نظر' : 'نظر جدید')
@section('page-title', $item->exists ? 'ویرایش نظر' : 'افزودن نظر')

@section('content')
    <form method="POST" action="{{ $item->exists ? route('admin.testimonials.update', $item) : route('admin.testimonials.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        <div class="a-card p-6">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">نام شخص (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" class="a-input" required>
                    @error('name')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Name (English)</label>
                    <input type="text" name="name_en" dir="ltr" value="{{ old('name_en', $item->name_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">سمت / رابطه (فارسی)</label>
                    <input type="text" name="position" value="{{ old('position', $item->position) }}" class="a-input" placeholder="مثال: مدیر فنی شرکت ...">
                </div>
                <div>
                    <label class="a-label">Position (English)</label>
                    <input type="text" name="position_en" dir="ltr" value="{{ old('position_en', $item->position_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">متن نظر (فارسی) <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="6" class="a-input" required>{{ old('content', $item->content) }}</textarea>
                    @error('content')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Content (English)</label>
                    <textarea name="content_en" dir="ltr" rows="6" class="a-input">{{ old('content_en', $item->content_en) }}</textarea>
                </div>
            </div>
        </div>

        <div class="a-card p-6">
            <label class="a-label">تصویر شخص (اختیاری)</label>
            <div class="flex flex-wrap items-center gap-5">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-100">
                    @if ($item->avatar_path)
                        <img id="avatar-preview" src="{{ asset($item->avatar_path) }}" class="h-full w-full object-cover">
                    @else
                        <i class="fa-regular fa-user text-xl text-slate-300"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" name="avatar" accept="image/*" data-preview="avatar-preview" class="a-input !py-2 file:me-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700">
                    <p class="a-hint">حداکثر ۲ مگابایت. اگر آپلود نشود، حرف اول نام نمایش داده می‌شود.</p>
                    @error('avatar')<p class="a-error">{{ $message }}</p>@enderror
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
                <a href="{{ route('admin.testimonials.index') }}" class="a-btn-ghost">انصراف</a>
                <button type="submit" class="a-btn-primary"><i class="fa-solid fa-floppy-disk"></i> ذخیره</button>
            </div>
        </div>
    </form>
@endsection
