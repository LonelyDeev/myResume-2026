@extends('layouts.admin')

@section('title', 'نمونه‌کارها')
@section('page-title', 'نمونه‌کارها')

@section('content')
    <div class="a-card">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h3 class="flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-folder-open text-brand-600"></i> لیست نمونه‌کارها
                <span class="a-badge bg-slate-100 text-slate-500">{{ $items->count() }}</span>
            </h3>
            <a href="{{ route('admin.portfolios.create') }}" class="a-btn-primary !px-4 !py-2 text-xs">
                <i class="fa-solid fa-plus"></i> نمونه‌کار جدید
            </a>
        </div>

        @forelse ($items as $item)
            <div class="flex flex-wrap items-center gap-4 border-b border-slate-100 px-6 py-4 transition last:border-0 hover:bg-slate-50">
                {{-- تصویر یا گرادیان --}}
                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-xl">
                    @if ($item->image_path)
                        <img src="{{ asset($item->image_path) }}" class="h-full w-full object-cover">
                    @else
                        <span class="flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-500 to-sky-600 text-lg font-black text-white">
                            {{ $item->initial() }}
                        </span>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <p class="font-bold text-slate-800">{{ $item->title }}</p>
                        @if ($item->is_featured)
                            <span class="a-badge bg-amber-50 text-amber-600"><i class="fa-solid fa-star text-[10px]"></i> شاخص</span>
                        @endif
                        @unless ($item->is_active)
                            <span class="a-badge-off">غیرفعال</span>
                        @endunless
                    </div>
                    <p class="truncate text-xs text-slate-400">
                        @if ($item->category) {{ $item->category }} · @endif
                        {{ \Illuminate\Support\Str::limit($item->description, 70) }}
                    </p>
                </div>

                <span class="a-badge bg-slate-100 text-slate-500">ترتیب: {{ $item->sort_order }}</span>

                <div class="flex items-center gap-2">
                    @if ($item->url)
                        <a href="{{ $item->url }}" target="_blank" rel="noopener"
                           class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-50 text-violet-600 transition hover:bg-violet-100" title="مشاهده سایت">
                            <i class="fa-solid fa-up-right-from-square text-xs"></i>
                        </a>
                    @endif
                    <a href="{{ route('admin.portfolios.edit', $item) }}"
                       class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600 transition hover:bg-sky-100" title="ویرایش">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.portfolios.destroy', $item) }}"
                          onsubmit="return confirm('آیا از حذف «{{ $item->title }}» مطمئن هستید؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-500 transition hover:bg-red-100" title="حذف">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="py-14 text-center">
                <i class="fa-regular fa-folder-open mb-3 block text-4xl text-slate-200"></i>
                <p class="mb-4 text-sm text-slate-400">هنوز نمونه‌کاری ثبت نشده است.</p>
                <a href="{{ route('admin.portfolios.create') }}" class="a-btn-primary !px-4 !py-2 text-xs">افزودن اولین نمونه‌کار</a>
            </div>
        @endforelse
    </div>
@endsection
