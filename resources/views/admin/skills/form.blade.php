@extends('layouts.admin')

@section('title', $item->exists ? 'ویرایش مهارت' : 'مهارت جدید')
@section('page-title', $item->exists ? 'ویرایش مهارت' : 'افزودن مهارت')

@section('content')
    <form method="POST" action="{{ $item->exists ? route('admin.skills.update', $item) : route('admin.skills.store') }}" class="space-y-6">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        <div class="a-card p-6">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">نام مهارت (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" class="a-input" required>
                    @error('name')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Skill Name (English)</label>
                    <input type="text" name="name_en" dir="ltr" value="{{ old('name_en', $item->name_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">دسته‌بندی (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="category" value="{{ old('category', $item->category) }}" class="a-input" list="skill-categories" required>
                    <datalist id="skill-categories">
                        @foreach (\App\Models\Skill::select('category')->distinct()->pluck('category') as $cat)
                            <option value="{{ $cat }}"></option>
                        @endforeach
                    </datalist>
                    <p class="a-hint">مهارت‌های هم‌دسته در یک کارت گروه می‌شوند. مثال: Backend & CMS — زبان‌ها</p>
                    @error('category')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Category (English)</label>
                    <input type="text" name="category_en" dir="ltr" value="{{ old('category_en', $item->category_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">سطح تسلط (درصد)</label>
                    <input type="number" name="level" min="0" max="100" value="{{ old('level', $item->level) }}" class="a-input" placeholder="خالی = نمایش به‌صورت تگ">
                    <p class="a-hint">بین ۰ تا ۱۰۰ — مناسب برای زبان‌ها یا مهارت‌های اصلی. اگر خالی باشد، مهارت به‌صورت تگ نمایش داده می‌شود.</p>
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
                <a href="{{ route('admin.skills.index') }}" class="a-btn-ghost">انصراف</a>
                <button type="submit" class="a-btn-primary"><i class="fa-solid fa-floppy-disk"></i> ذخیره</button>
            </div>
        </div>
    </form>
@endsection
