@extends('layouts.admin')

@section('title', 'پیام‌ها')
@section('page-title', 'پیام‌های دریافتی')

@section('content')
    <div class="a-card">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <h3 class="flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-envelope text-brand-600"></i> صندوق پیام‌ها
                <span class="a-badge bg-slate-100 text-slate-500">{{ $items->count() }}</span>
            </h3>
        </div>

        @forelse ($items as $message)
            <a href="{{ route('admin.messages.show', $message) }}"
               class="flex flex-wrap items-center gap-4 border-b border-slate-100 px-6 py-4 transition last:border-0 hover:bg-slate-50">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full {{ $message->is_read ? 'bg-slate-100 text-slate-400' : 'bg-brand-50 text-brand-600' }}">
                    <i class="fa-solid {{ $message->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                </span>

                <div class="min-w-0 flex-1">
                    <p class="{{ $message->is_read ? 'font-medium text-slate-500' : 'font-black text-slate-800' }}">
                        {{ $message->name }}
                        @unless ($message->is_read)
                            <span class="a-badge bg-brand-50 text-brand-600">جدید</span>
                        @endunless
                    </p>
                    <p class="truncate text-xs text-slate-400">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 60) }}</p>
                </div>

                <span dir="ltr" class="text-xs text-slate-400">{{ $message->email }}</span>
                <span dir="ltr" class="text-xs text-slate-400">{{ $message->mobile }}</span>
                <span class="shrink-0 text-[11px] text-slate-400">{{ $message->created_at->format('Y/m/d H:i') }}</span>
            </a>
        @empty
            <div class="py-14 text-center">
                <i class="fa-regular fa-envelope-open mb-3 block text-4xl text-slate-200"></i>
                <p class="text-sm text-slate-400">صندوق پیام خالی است.</p>
            </div>
        @endforelse
    </div>
@endsection
