<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\UploadsMedia;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;

class PersonalInfoController extends Controller
{
    use UploadsMedia;

    public function edit()
    {
        $info = PersonalInfo::first() ?? new PersonalInfo();

        return view('admin.personal-info.edit', compact('info'));
    }

    public function update(Request $request)
    {
        $info = PersonalInfo::first() ?? new PersonalInfo();

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:100'],
            'name_en'         => ['nullable', 'string', 'max:100'],
            'job_title'       => ['required', 'string', 'max:200'],
            'job_title_en'    => ['nullable', 'string', 'max:200'],
            'tagline'         => ['nullable', 'string', 'max:300'],
            'tagline_en'      => ['nullable', 'string', 'max:300'],
            'bio'             => ['nullable', 'string'],
            'bio_en'          => ['nullable', 'string'],
            'abilities'       => ['nullable', 'string'],
            'abilities_en'    => ['nullable', 'string'],
            'email'           => ['nullable', 'email', 'max:150'],
            'phone'           => ['nullable', 'string', 'max:32'],
            'secondary_phone' => ['nullable', 'string', 'max:32'],
            'website'         => ['nullable', 'string', 'max:200'],
            'telegram'        => ['nullable', 'string', 'max:100'],
            'birth_date'      => ['nullable', 'string', 'max:100'],
            'birth_date_en'   => ['nullable', 'string', 'max:100'],
            'city'            => ['nullable', 'string', 'max:150'],
            'city_en'         => ['nullable', 'string', 'max:150'],
            'avatar'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cv'              => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $validated['avatar_path'] = $this->uploadMedia($request->file('avatar'), 'avatar', $info->avatar_path);
        $validated['cv_path']     = $this->uploadMedia($request->file('cv'), 'cv', $info->cv_path);

        $info->update($validated);

        return back()->with('success', 'اطلاعات شخصی با موفقیت بروزرسانی شد.');
    }
}
