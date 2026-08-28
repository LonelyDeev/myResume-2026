@extends('layouts.admin')

@section('title', 'اطلاعات شخصی')
@section('page-title', 'ویرایش اطلاعات شخصی')

@section('content')
    <form method="POST" action="{{ route('admin.personal-info.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- هویت --}}
        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-id-card text-brand-600"></i> هویت
            </h3>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">نام و نام خانوادگی (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $info->name) }}" class="a-input {{ $errors->has('name') ? '!border-red-400' : '' }}" required>
                    @error('name')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Full Name (English)</label>
                    <input type="text" name="name_en" dir="ltr" value="{{ old('name_en', $info->name_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">عنوان شغلی (فارسی) <span class="text-red-500">*</span></label>
                    <input type="text" name="job_title" value="{{ old('job_title', $info->job_title) }}" class="a-input" placeholder="مثال: توسعه‌دهنده Back-End | متخصص Laravel">
                    <p class="a-hint">برای افکت تایپ در صفحه اصلی، چند عنوان را با کاراکتر | از هم جدا کنید.</p>
                    @error('job_title')<p class="a-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="a-label">Job Title (English)</label>
                    <input type="text" name="job_title_en" dir="ltr" value="{{ old('job_title_en', $info->job_title_en) }}" class="a-input">
                </div>

                <div>
                    <label class="a-label">شعار کوتاه (فارسی)</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $info->tagline) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">Tagline (English)</label>
                    <input type="text" name="tagline_en" dir="ltr" value="{{ old('tagline_en', $info->tagline_en) }}" class="a-input">
                </div>
            </div>
        </div>

        {{-- درباره من --}}
        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-circle-user text-brand-600"></i> درباره من
            </h3>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">بیوگرافی (فارسی)</label>
                    <textarea name="bio" rows="6" class="a-input">{{ old('bio', $info->bio) }}</textarea>
                    <p class="a-hint">هر خط به‌صورت یک پاراگراف جداگانه نمایش داده می‌شود.</p>
                </div>
                <div>
                    <label class="a-label">Biography (English)</label>
                    <textarea name="bio_en" dir="ltr" rows="6" class="a-input">{{ old('bio_en', $info->bio_en) }}</textarea>
                </div>

                <div>
                    <label class="a-label">توانمندی‌های کلیدی (فارسی)</label>
                    <textarea name="abilities" rows="6" class="a-input">{{ old('abilities', $info->abilities) }}</textarea>
                    <p class="a-hint">هر خط = یک توانمندی (به‌صورت چیپ نمایش داده می‌شود).</p>
                </div>
                <div>
                    <label class="a-label">Key Abilities (English)</label>
                    <textarea name="abilities_en" dir="ltr" rows="6" class="a-input">{{ old('abilities_en', $info->abilities_en) }}</textarea>
                </div>
            </div>
        </div>

        {{-- اطلاعات تماس --}}
        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-address-book text-brand-600"></i> اطلاعات تماس و شخصی
            </h3>

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label class="a-label">ایمیل</label>
                    <input type="email" name="email" dir="ltr" value="{{ old('email', $info->email) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">شماره تماس</label>
                    <input type="text" name="phone" dir="ltr" value="{{ old('phone', $info->phone) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">شماره دوم</label>
                    <input type="text" name="secondary_phone" dir="ltr" value="{{ old('secondary_phone', $info->secondary_phone) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">وب‌سایت</label>
                    <input type="text" name="website" dir="ltr" value="{{ old('website', $info->website) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">آیدی تلگرام</label>
                    <input type="text" name="telegram" dir="ltr" value="{{ old('telegram', $info->telegram) }}" class="a-input" placeholder="بدون @">
                </div>
                <div></div>

                <div>
                    <label class="a-label">تاریخ تولد (فارسی)</label>
                    <input type="text" name="birth_date" value="{{ old('birth_date', $info->birth_date) }}" class="a-input" placeholder="مثال: ۲۳ مرداد ۱۳۷۷">
                </div>
                <div>
                    <label class="a-label">Birth Date (English)</label>
                    <input type="text" name="birth_date_en" dir="ltr" value="{{ old('birth_date_en', $info->birth_date_en) }}" class="a-input">
                </div>
                <div></div>

                <div>
                    <label class="a-label">محل سکونت (فارسی)</label>
                    <input type="text" name="city" value="{{ old('city', $info->city) }}" class="a-input">
                </div>
                <div>
                    <label class="a-label">Location (English)</label>
                    <input type="text" name="city_en" dir="ltr" value="{{ old('city_en', $info->city_en) }}" class="a-input">
                </div>
            </div>
        </div>

        {{-- تصویر و رزومه --}}
        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-image-portrait text-brand-600"></i> تصویر پروفایل و فایل رزومه
            </h3>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="a-label">تصویر پروفایل</label>
                    <div class="flex items-center gap-4">
                        <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-slate-100">
                            @if ($info->avatar_path)
                                <img id="avatar-preview" src="{{ Storage::url($info->avatar_path) }}" class="h-full w-full object-cover">
                            @else
                                <i class="fa-solid fa-user text-2xl text-slate-300"></i>
                            @endif
                        </div>
                        <input type="file" name="avatar" accept="image/*" data-preview="avatar-preview" class="a-input !py-2 file:me-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700">
                    </div>
                    <p class="a-hint">فرمت‌های مجاز: jpg، png، webp — حداکثر ۲ مگابایت. اگر تصویر نباشد، حرف اول نام نمایش داده می‌شود.</p>
                    @error('avatar')<p class="a-error">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="a-label">فایل رزومه (PDF)</label>
                    <input type="file" name="cv" accept=".pdf" class="a-input !py-2 file:me-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700">
                    <p class="a-hint">
                        @if ($info->cv_path)
                            فایل فعلی: <span dir="ltr" class="font-bold text-slate-600">{{ $info->cv_path }}</span>
                        @else
                            با آپلود فایل PDF، دکمه «دانلود رزومه» در صفحه اصلی فعال می‌شود.
                        @endif
                    </p>
                    @error('cv')<p class="a-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="a-btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> ذخیره تغییرات
            </button>
        </div>
    </form>
@endsection
