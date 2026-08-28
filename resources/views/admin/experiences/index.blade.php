@extends('layouts.admin')

@section('title', 'تجربه‌های کاری')
@section('page-title', 'تجربه‌های کاری')

@section('content')
    <div class="a-card">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h3 class="flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-briefcase text-brand-600"></i> لیست تجربه‌های کاری
                <span class="a-badge bg-slate-100 text-slate-500">{{ $items->count() }}</span>
            </h3>
            <a href="{{ route('admin.experiences.create') }}" class="a-btn-primary !px-4 !py-2 text-xs">
                <i class="fa-solid fa-plus"></i> تجربه جدید
            </a>
        </div>

        @forelse ($items as $item)
            <div class="flex flex-wrap items-center gap-4 border-b border-slate-100 px-6 py-4 transition last:border-0 hover:bg-slate-50">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $item->is_current ? 'bg-brand-50 text-brand-600' : 'bg-slate-100 text-slate-400' }}">
                    <i class="fa-solid fa-building"></i>
                </span>

                <div class="min-w-0 flex-1">
                    <div class="mb-1 flex flex-wrap items-center gap-2">
                        <p class="font-bold text-slate-800">{{ $item->position }}</p>
                        @if ($item->is_current)
                            <span class="a-badge bg-brand-50 text-brand-600">شغل فعلی</span>
                        @endif
                        @unless ($item->is_active)
                            <span class="a-badge-off">غیرفعال</span>
                        @endunless
                    </div>
                    <p class="truncate text-xs text-slate-400">{{ $item->company }} · {{ $item->period }}</p>
                </div>

                <span class="a-badge bg-slate-100 text-slate-500">ترتیب: {{ $item->sort_order }}</span>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.experiences.edit', $item) }}"
                       class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600 transition hover:bg-sky-100" title="ویرایش">
                        <i class="fa-solid fa-pen text-xs"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.experiences.destroy', $item) }}"
                          onsubmit="return confirm('آیا از حذف «{{ $item->position }}» مطمئن هستید؟')">
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
                <p class="mb-4 text-sm text-slate-400">هنوز تجربه کاری ثبت نشده است.</p>
                <a href="{{ route('admin.experiences.create') }}" class="a-btn-primary !px-4 !py-2 text-xs">افزودن اولین تجربه</a>
            </div>
        @endforelse
    </div>
@endsection
