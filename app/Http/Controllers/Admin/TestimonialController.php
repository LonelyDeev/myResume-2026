<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\UploadsMedia;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use UploadsMedia;

    public function index()
    {
        $items = Testimonial::ordered()->get();

        return view('admin.testimonials.index', compact('items'));
    }

    public function create()
    {
        return view('admin.testimonials.form', ['item' => new Testimonial()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $validated['avatar_path'] = $this->uploadMedia($request->file('avatar'), 'testimonials');

        Testimonial::create($validated);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'نظر جدید اضافه شد.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', ['item' => $testimonial]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $this->validated($request);

        $validated['avatar_path'] = $this->uploadMedia($request->file('avatar'), 'testimonials', $testimonial->avatar_path);

        $testimonial->update($validated);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'نظر بروزرسانی شد.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteMedia($testimonial->avatar_path);

        $testimonial->delete();

        return back()->with('success', 'نظر حذف شد.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'         => ['required', 'string', 'max:200'],
            'name_en'      => ['nullable', 'string', 'max:200'],
            'position'     => ['nullable', 'string', 'max:250'],
            'position_en'  => ['nullable', 'string', 'max:250'],
            'content'      => ['required', 'string'],
            'content_en'   => ['nullable', 'string'],
            'avatar'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
            'is_active'    => ['nullable', 'boolean'],
        ]);
    }
}
