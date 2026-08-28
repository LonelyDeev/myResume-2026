<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $items = SocialLink::ordered()->get();

        return view('admin.social-links.index', compact('items'));
    }

    public function create()
    {
        return view('admin.social-links.form', ['item' => new SocialLink()]);
    }

    public function store(Request $request)
    {
        SocialLink::create($this->validated($request));

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'لینک جدید اضافه شد.');
    }

    public function edit(SocialLink $social_link)
    {
        return view('admin.social-links.form', ['item' => $social_link]);
    }

    public function update(Request $request, SocialLink $social_link)
    {
        $social_link->update($this->validated($request));

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'لینک بروزرسانی شد.');
    }

    public function destroy(SocialLink $social_link)
    {
        $social_link->delete();

        return back()->with('success', 'لینک حذف شد.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'platform'   => ['required', 'string', 'max:100'],
            'url'        => ['required', 'string', 'max:500'],
            'icon'       => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);
    }
}
