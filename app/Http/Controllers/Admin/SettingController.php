<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::current();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::current();

        $validated = $request->validate([
            'site_title'          => ['required', 'string', 'max:150'],
            'site_title_en'       => ['nullable', 'string', 'max:150'],
            'meta_description'    => ['nullable', 'string', 'max:500'],
            'meta_description_en' => ['nullable', 'string', 'max:500'],
            'footer_text'         => ['nullable', 'string', 'max:250'],
            'footer_text_en'      => ['nullable', 'string', 'max:250'],
            'contact_intro'       => ['nullable', 'string', 'max:500'],
            'contact_intro_en'    => ['nullable', 'string', 'max:500'],
        ]);

        // چک‌باکس‌های نمایش سکشن‌ها
        $sections = [
            'show_about',
            'show_experience',
            'show_education',
            'show_skills',
            'show_portfolios',
            'show_testimonials',
            'show_contact',
        ];

        foreach ($sections as $section) {
            $validated[$section] = $request->boolean($section);
        }

        $settings->update($validated);
        Artisan::call('storage:link');
        return back()->with('success', 'تنظیمات سایت ذخیره شد.');
    }
}
