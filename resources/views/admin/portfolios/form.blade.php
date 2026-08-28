@extends('layouts.admin')

@section('title', $item->exists ? 'ویرایش نمونه‌کار' : 'نمونه‌کار جدید')
@section('page-title', $item->exists ? 'ویرایش نمونه‌کار' : 'افزودن نمونه‌کار')

@section('content')
    <form method="POST" action="{{ $item->exists ? route('admin.portfolios.update', $item) : route('admin.portfolios.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if ($item->exists) @method('PUT') @endif

        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-circle-info text-brand-600"></i> اطلاعات اصلی
            </h3>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">عنوان پروژه (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $item->title) }}" class="a-input" required>
                    @error('title')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Title (English)</label>
                    <input type="text" name="title_en" dir="ltr" value="{{ old('title_en', $item->title_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">دسته‌بندی (فارسی)</label>
                    <input type="text" name="category" value="{{ old('category', $item->category) }}" class="a-input" list="portfolio-categories" placeholder="مثال: فروشگاه آنلاین">
                    <datalist id="portfolio-categories">
                        @foreach (\App\Models\Portfolio::select('category')->distinct()->pluck('category')->filter() as $cat)
                            <option value="{{ $cat }}"></option>
                        @endforeach
                    </datalist>
                    <p class="a-hint">بر اساس دسته‌بندی، فیلتر صفحه اصلی ساخته می‌شود.</p>
                </div>
                <div>
                    <label class="a-label">Category (English)</label>
                    <input type="text" name="category_en" dir="ltr" value="{{ old('category_en', $item->category_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">کارفرما (فارسی)</label>
                    <input type="text" name="client" value="{{ old('client', $item->client) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">Client (English)</label>
                    <input type="text" name="client_en" dir="ltr" value="{{ old('client_en', $item->client_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">لینک پروژه</label>
                    <input type="url" name="url" dir="ltr" value="{{ old('url', $item->url) }}" class="a-input" placeholder="https://example.com">
                </div>
                <div>
                    <label class="a-label">تگ‌های تکنولوژی</label>
                    <input type="text" name="tech_tags" dir="ltr" value="{{ old('tech_tags', $item->tech_tags) }}" class="a-input" placeholder="Laravel, MySQL, Redis">
                    <p class="a-hint">با کاما جدا کنید.</p>
                </div>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">توضیحات (فارسی)</label>
                    <textarea name="description" rows="7" class="a-input">{{ old('description', $item->description) }}</textarea>
                    <p class="a-hint">هر خط در مودال جزئیات به‌صورت بولت نمایش داده می‌شود.</p>
                </div>
                <div>
                    <label class="a-label">Description (English)</label>
                    <textarea name="description_en" dir="ltr" rows="7" class="a-input">{{ old('description_en', $item->description_en) }}</textarea>
                </div>
            </div>
        </div>

        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-image text-brand-600"></i> تصویر پروژه
            </h3>

            <div class="flex flex-wrap items-center gap-5">
                <div class="flex h-24 w-40 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-slate-100">
                    @if ($item->image_path)
                        <img id="image-preview" src="{{ Storage::url($item->image_path) }}" class="h-full w-full object-cover">
                    @else
                        <i class="fa-regular fa-image text-2xl text-slate-300"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" name="image" accept="image/*" data-preview="image-preview" class="a-input !py-2 file:me-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700">
                    <p class="a-hint">فرمت‌های مجاز: jpg، png، webp — حداکثر ۴ مگابایت. اگر تصویر آپلود نشود، کارت گرادیانی با حرف اول پروژه نمایش داده می‌شود.</p>
                    @error('image')<p class="a-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="a-card flex flex-wrap items-center justify-between gap-4 p-6">
            <div class="flex flex-wrap items-center gap-6">
                <label class="flex cursor-pointer items-center gap-2.5">
                    <input type="checkbox" name="is_featured" value="1" class="h-4 w-4 rounded accent-brand-600" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }}>
                    <span class="text-sm font-bold text-slate-700">پروژه شاخص <i class="fa-solid fa-star text-amber-500"></i></span>
                </label>
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
                <a href="{{ route('admin.portfolios.index') }}" class="a-btn-ghost">انصراف</a>
                <button type="submit" class="a-btn-primary"><i class="fa-solid fa-floppy-disk"></i> ذخیره</button>
            </div>
        </div>
    </form>
@endsection
