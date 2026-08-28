@extends('layouts.admin')

@section('title', $item->exists ? 'ویرایش مورد تحصیلی' : 'مورد تحصیلی جدید')
@section('page-title', $item->exists ? 'ویرایش مورد تحصیلی' : 'افزودن مورد تحصیلی')

@section('content')
    <form method="POST" action="{{ $item->exists ? route('admin.educations.update', $item) : route('admin.educations.store') }}" class="space-y-6">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        <div class="a-card p-6">
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">مدرک / عنوان (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="degree" value="{{ old('degree', $item->degree) }}" class="a-input" placeholder="مثال: کارشناسی مهندسی کامپیوتر" required>
                    @error('degree')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Degree (English)</label>
                    <input type="text" name="degree_en" dir="ltr" value="{{ old('degree_en', $item->degree_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">مؤسسه (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="institution" value="{{ old('institution', $item->institution) }}" class="a-input" required>
                    @error('institution')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Institution (English)</label>
                    <input type="text" name="institution_en" dir="ltr" value="{{ old('institution_en', $item->institution_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">بازه زمانی (فارسی)</label>
                    <input type="text" name="period" value="{{ old('period', $item->period) }}" class="a-input" placeholder="مثال: ۱۳۹۹ - ۱۴۰۲">
                </div>
                <div>
                    <label class="a-label">Period (English)</label>
                    <input type="text" name="period_en" dir="ltr" value="{{ old('period_en', $item->period_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">توضیحات (فارسی)</label>
                    <textarea name="description" rows="4" class="a-input">{{ old('description', $item->description) }}</textarea>
                </div>
                <div>
                    <label class="a-label">Description (English)</label>
                    <textarea name="description_en" dir="ltr" rows="4" class="a-input">{{ old('description_en', $item->description_en) }}</textarea>
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
                <a href="{{ route('admin.educations.index') }}" class="a-btn-ghost">انصراف</a>
                <button type="submit" class="a-btn-primary"><i class="fa-solid fa-floppy-disk"></i> ذخیره</button>
            </div>
        </div>
    </form>
@endsection
