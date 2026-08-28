@extends('layouts.admin')

@section('title', 'داشبورد')
@section('page-title', 'داشبورد')

@section('content')
    {{-- بنر خوش‌آمد --}}
    <div class="a-card relative mb-8 overflow-hidden bg-navy-900 p-8 text-white">
        <div class="absolute -top-24 -start-24 h-64 w-64 rounded-full bg-brand-500/25 blur-3xl"></div>
        <div class="absolute -bottom-24 -end-16 h-56 w-56 rounded-full bg-sky-500/20 blur-3xl"></div>
        <div class="relative">
            <p class="mb-2 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-brand-300">
                <i class="fa-solid fa-hand-sparkles"></i> خوش آمدید
            </p>
            <h2 class="mb-2 text-2xl font-black">{{ auth()->user()->name }} عزیز،</h2>
            <p class="max-w-xl text-sm leading-relaxed text-slate-300">
                از این پنل تمام محتوای سایت رزومه — اطلاعات شخصی، تجربه‌ها، مهارت‌ها، نمونه‌کارها و پیام‌ها — را مدیریت کنید.
            </p>
        </div>
    </div>

    {{-- کارت‌های آمار --}}
    <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-6">
        @foreach ([
            ['route' => 'admin.experiences.index', 'icon' => 'fa-briefcase', 'label' => 'تجربه کاری', 'value' => $stats['experiences'], 'color' => 'text-sky-600 bg-sky-50'],
            ['route' => 'admin.educations.index',  'icon' => 'fa-graduation-cap', 'label' => 'تحصیلات', 'value' => $stats['educations'], 'color' => 'text-violet-600 bg-violet-50'],
            ['route' => 'admin.skills.index',      'icon' => 'fa-bolt', 'label' => 'مهارت', 'value' => $stats['skills'], 'color' => 'text-amber-600 bg-amber-50'],
            ['route' => 'admin.portfolios.index',  'icon' => 'fa-folder-open', 'label' => 'نمونه‌کار', 'value' => $stats['portfolios'], 'color' => 'text-brand-600 bg-brand-50'],
            ['route' => 'admin.testimonials.index','icon' => 'fa-comment-dots', 'label' => 'نظر', 'value' => $stats['testimonials'], 'color' => 'text-pink-600 bg-pink-50'],
            ['route' => 'admin.messages.index',    'icon' => 'fa-envelope', 'label' => 'پیام خوانده‌نشده', 'value' => $stats['unread'], 'color' => 'text-red-600 bg-red-50'],
        ] as $card)
            <a href="{{ route($card['route']) }}"
               class="a-card group flex items-center gap-3 p-4 transition hover:-translate-y-0.5 hover:shadow-md">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $card['color'] }} transition group-hover:scale-110">
                    <i class="fa-solid {{ $card['icon'] }}"></i>
                </span>
                <div>
                    <p class="text-xl font-black text-slate-800">{{ $card['value'] }}</p>
                    <p class="text-xs font-bold text-slate-400">{{ $card['label'] }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- آخرین پیام‌ها --}}
        <div class="a-card p-6 lg:col-span-2">
            <div class="mb-5 flex items-center justify-between">
                <h3 class="flex items-center gap-2 font-black text-slate-800">
                    <i class="fa-solid fa-inbox text-brand-600"></i> آخرین پیام‌ها
                </h3>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">
                    مشاهده همه <i class="fa-solid fa-angle-left"></i>
                </a>
            </div>

            @forelse ($latestMessages as $message)
                <a href="{{ route('admin.messages.show', $message) }}"
                   class="flex items-center gap-4 border-b border-slate-100 py-3.5 transition last:border-0 hover:bg-slate-50">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $message->is_read ? 'bg-slate-100 text-slate-400' : 'bg-brand-50 text-brand-600' }}">
                        <i class="fa-solid {{ $message->is_read ? 'fa-envelope-open' : 'fa-envelope' }}"></i>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold {{ $message->is_read ? 'text-slate-500' : 'text-slate-800' }}">
                            {{ $message->name }}
                            @unless ($message->is_read)
                                <span class="a-badge bg-brand-50 text-brand-600">جدید</span>
                            @endunless
                        </p>
                        <p class="truncate text-xs text-slate-400">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 60) }}</p>
                    </div>
                    <span class="shrink-0 text-[11px] text-slate-400">{{ $message->created_at->diffForHumans() }}</span>
                </a>
            @empty
                <div class="py-10 text-center text-sm text-slate-400">
                    <i class="fa-regular fa-envelope-open mb-3 block text-3xl text-slate-300"></i>
                    هنوز پیامی دریافت نشده است.
                </div>
            @endforelse
        </div>

        {{-- دسترسی سریع --}}
        <div class="a-card p-6">
            <h3 class="mb-5 flex items-center gap-2 font-black text-slate-800">
                <i class="fa-solid fa-bolt text-amber-500"></i> دسترسی سریع
            </h3>
            <div class="space-y-2.5">
                @foreach ([
                    ['route' => 'admin.personal-info.edit', 'icon' => 'fa-user-gear', 'label' => 'ویرایش اطلاعات شخصی'],
                    ['route' => 'admin.portfolios.create',  'icon' => 'fa-plus', 'label' => 'افزودن نمونه‌کار جدید'],
                    ['route' => 'admin.experiences.create', 'icon' => 'fa-plus', 'label' => 'افزودن تجربه کاری'],
                    ['route' => 'admin.skills.create',      'icon' => 'fa-plus', 'label' => 'افزودن مهارت'],
                    ['route' => 'admin.settings.edit',      'icon' => 'fa-gear', 'label' => 'تنظیمات سایت'],
                ] as $link)
                    <a href="{{ route($link['route']) }}"
                       class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-700">
                        <i class="fa-solid {{ $link['icon'] }} w-5 text-center"></i> {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
