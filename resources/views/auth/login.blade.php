@extends('layouts.guest-lite')

@section('content')
<div class="relative z-10 mx-auto flex min-h-screen w-full max-w-md flex-col justify-center px-5 py-12">
    {{-- لوگو و عنوان --}}
    <div class="mb-9 text-center">
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-brand-400 to-sky-500 text-xl font-black text-navy-950 shadow-lg shadow-brand-500/30">
            M
        </div>
        <h1 class="mb-2 text-2xl font-black text-white">ورود به پنل مدیریت</h1>
        <p class="text-sm text-slate-400">برای مدیریت محتوای رزومه وارد شوید</p>
    </div>

    {{-- فرم ورود --}}
    <form method="POST" action="{{ route('login') }}" class="glass rounded-3xl p-8 shadow-2xl">
        @csrf

        {{-- پیام وضعیت (بازیابی رمز و ...) --}}
        @if (session('status'))
            <div class="mb-5 rounded-2xl border border-brand-400/30 bg-brand-400/10 px-4 py-3 text-xs font-bold text-brand-300">
                {{ session('status') }}
            </div>
        @endif

        {{-- ایمیل --}}
        <div class="mb-5">
            <label for="email" class="mb-2 block text-xs font-black text-slate-400">{{ __('Email') }}</label>
            <div class="relative">
                <i class="fa-solid fa-envelope pointer-events-none absolute start-4 top-1/2 -translate-y-1/2 text-sm text-slate-500"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" dir="ltr" required autofocus
                       autocomplete="username"
                       class="f-input !ps-11 {{ $errors->has('email') ? '!border-red-400/60' : '' }}"
                       placeholder="admin@example.com">
            </div>
            @error('email')
                <p class="mt-2 text-xs font-bold text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- رمز عبور --}}
        <div class="mb-5">
            <label for="password" class="mb-2 block text-xs font-black text-slate-400">{{ __('Password') }}</label>
            <div class="relative">
                <i class="fa-solid fa-lock pointer-events-none absolute start-4 top-1/2 -translate-y-1/2 text-sm text-slate-500"></i>
                <input id="password" type="password" name="password" dir="ltr" required
                       autocomplete="current-password"
                       class="f-input !ps-11 {{ $errors->has('password') ? '!border-red-400/60' : '' }}"
                       placeholder="••••••••">
            </div>
        </div>

        {{-- مرا به خاطر بسپار --}}
        <div class="mb-7 flex items-center justify-between">
            <label class="flex cursor-pointer items-center gap-2.5 text-xs font-bold text-slate-400">
                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-white/5 accent-brand-500">
                {{ __('Remember me') }}
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-bold text-brand-300 transition hover:text-brand-400">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="f-btn-primary w-full">
            <i class="fa-solid fa-right-to-bracket"></i> ورود
        </button>

        @if (Route::has('register'))
            <p class="mt-6 text-center text-xs text-slate-500">
                حساب کاربری ندارید؟
                <a href="{{ route('register') }}" class="font-bold text-brand-300 transition hover:text-brand-400">ثبت‌نام</a>
            </p>
        @endif
    </form>

    {{-- بازگشت به سایت --}}
    <div class="mt-6 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 transition hover:text-brand-300">
            <i class="fa-solid fa-arrow-right"></i>
            بازگشت به سایت
        </a>
    </div>
</div>
@endsection
