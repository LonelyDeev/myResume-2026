@extends('layouts.admin')

@section('title', 'مهارت‌ها')
@section('page-title', 'مهارت‌ها')

@section('content')
    <div class="a-card">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <div>
                <h3 class="flex items-center gap-2 font-black text-slate-800">
                    <i class="fa-solid fa-bolt text-brand-600"></i> لیست مهارت‌ها
                    <span class="a-badge bg-slate-100 text-slate-500">{{ $items->count() }}</span>
                </h3>
                <p class="mt-1 text-xs text-slate-400">مهارت با «سطح» به‌صورت نوار پیشرفت و بدون سطح به‌صورت تگ نمایش داده می‌شود.</p>
            </div>
            <a href="{{ route('admin.skills.create') }}" class="a-btn-primary !px-4 !py-2 text-xs">
                <i class="fa-solid fa-plus"></i> مهارت جدید
            </a>
        </div>

        @forelse ($items as $item)
            <div class="flex flex-wrap items-center gap-4 border-b border-slate-100 px-6 py-3.5 transition last:border-0 hover:bg-slate-50">
                <span class="a-badge bg-brand-50 text-brand-700">{{ $item->category }}</span>

                <div class="min-w-0 flex-1">
                    <p class="font-bold text-slate-800">
                        {{ $item->name }}
                        @if (!is_null($item->level))
                            <span class="a-badge bg-amber-50 text-amber-600">سطح {{ $item->level }}٪</span>
                        @endif
                        @unless ($item->is_active)
                            <span class="a-badge-off">غیرفعال</span>
                        @endunless
                    </p>
                </div>

                <span class="a-badge bg-slate-100 text-slate-500">ترتیب: {{ $item->sort_order }}</span>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.skills.edit', $item) }}"
                       class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600 transition hover:bg-sky-100" title="ویرایش">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.skills.destroy', $item) }}"
                          onsubmit="return confirm('آیا از حذف «{{ $item->name }}» مطمئن هستید؟')">
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
                <p class="mb-4 text-sm text-slate-400">هنوز مهارتی ثبت نشده است.</p>
                <a href="{{ route('admin.skills.create') }}" class="a-btn-primary !px-4 !py-2 text-xs">افزودن اولین مهارت</a>
            </div>
        @endforelse
    </div>
@endsection
