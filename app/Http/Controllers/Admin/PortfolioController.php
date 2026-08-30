<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\UploadsMedia;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    use UploadsMedia;

    public function index()
    {
        $items = Portfolio::ordered()->get();

        return view('admin.portfolios.index', compact('items'));
    }

    public function create()
    {
        return view('admin.portfolios.form', ['item' => new Portfolio()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $validated['image_path']    = $this->uploadMedia($request->file('image'), 'portfolios');
        $validated['gallery_paths'] = $this->uploadGallery($request);

        Portfolio::create($validated);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'نمونه‌کار جدید اضافه شد.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolios.form', ['item' => $portfolio]);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $this->validated($request);

        $validated['image_path']    = $this->uploadMedia($request->file('image'), 'portfolios', $portfolio->image_path);
        $validated['gallery_paths'] = $this->uploadGallery($request, $portfolio);

        $portfolio->update($validated);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'نمونه‌کار بروزرسانی شد.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->deleteMedia($portfolio->image_path);

        foreach ((array) ($portfolio->gallery_paths ?? []) as $path) {
            $this->deleteMedia($path);
        }

        $portfolio->delete();

        return back()->with('success', 'نمونه‌کار حذف شد.');
    }

    /**
     * آپلود تصاویر گالری چندتایی + حذف تصاویر تیک‌خورده در حالت ویرایش
     */
    private function uploadGallery(Request $request, ?Portfolio $portfolio = null): array
    {
        $paths = (array) ($portfolio?->gallery_paths ?? []);

        // تصاویر انتخاب‌شده برای حذف
        $removed = array_filter((array) $request->input('remove_gallery', []));

        if ($removed) {
            foreach ($removed as $path) {
                $this->deleteMedia((string) $path);
            }

            $paths = array_values(array_diff($paths, $removed));
        }

        // فایل‌های جدید
        foreach ((array) $request->file('gallery', []) as $file) {
            if ($file && $file->isValid()) {
                $paths[] = $file->store('portfolios', 'public');
            }
        }

        return array_values($paths);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'          => ['required', 'string', 'max:250'],
            'title_en'       => ['nullable', 'string', 'max:250'],
            'category'       => ['nullable', 'string', 'max:150'],
            'category_en'    => ['nullable', 'string', 'max:150'],
            'client'         => ['nullable', 'string', 'max:200'],
            'client_en'      => ['nullable', 'string', 'max:200'],
            'url'            => ['nullable', 'url', 'max:500'],
            'description'    => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'tech_tags'      => ['nullable', 'string', 'max:500'],
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp'],
            'gallery'        => ['nullable', 'array', 'max:12'],
            'gallery.*'      => ['image', 'mimes:jpg,jpeg,png,webp'],
            'remove_gallery' => ['nullable', 'array'],
            'is_featured'    => ['nullable', 'boolean'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],
            'is_active'      => ['nullable', 'boolean'],
        ]);
    }
}
