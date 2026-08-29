@extends('layouts.admin')

@section('title', 'مشاهده پیام')
@section('page-title', 'پیام از طرف ' . $message->name)

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <div class="a-card overflow-hidden">
            <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h3 class="mb-1 text-lg font-black text-slate-800">{{ $message->subject ?: 'بدون موضوع' }}</h3>
                        <div class="space-y-0.5 text-sm text-slate-500">
                            <p><i class="fa-solid fa-user w-5 text-slate-400"></i> {{ $message->name }}</p>
                            <p><i class="fa-solid fa-envelope w-5 text-slate-400"></i> <span dir="ltr">{{ $message->email }}</span></p>
                            <p><i class="fa-solid fa-envelope w-5 text-slate-400"></i> <span dir="ltr">{{ $message->mobile }}</span></p>
                            <p><i class="fa-solid fa-calendar w-5 text-slate-400"></i> {{ $message->created_at->format('Y/m/d — H:i') }} ({{ $message->created_at->diffForHumans() }})</p>
                        </div>
                    </div>
                    @unless ($message->is_read)
                        <span class="a-badge bg-brand-50 text-brand-600">خوانده نشده</span>
                    @endunless
                </div>
            </div>

            <div class="px-6 py-6">
                <p class="whitespace-pre-line leading-8 text-slate-700">{{ $message->message }}</p>
            </div>

            <div class="flex flex-wrap gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . ($message->subject ?? '')) }}" class="a-btn-primary !px-4 !py-2 text-xs">
                    <i class="fa-solid fa-reply"></i> پاسخ با ایمیل
                </a>
                <a href="{{ route('admin.messages.index') }}" class="a-btn-ghost !px-4 !py-2 text-xs">
                    <i class="fa-solid fa-arrow-right"></i> بازگشت به صندوق
                </a>
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="ms-auto"
                      onsubmit="return confirm('آیا از حذف این پیام مطمئن هستید؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="a-btn-danger !px-4 !py-2 text-xs">
                        <i class="fa-solid fa-trash"></i> حذف پیام
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
