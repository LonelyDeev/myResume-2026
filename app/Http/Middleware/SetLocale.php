<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * تنظیم خودکار زبان اپلیکیشن بر اساس سگمنت اول URL
 * مثال: /fa/...  =>  fa (RTL)   |   /en/...  =>  en (LTR)
 */
class SetLocale
{
    public const LOCALES = ['fa', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (in_array($locale, self::LOCALES, true)) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}
