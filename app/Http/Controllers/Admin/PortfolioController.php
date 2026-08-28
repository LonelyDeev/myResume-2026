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

        $validated['image_path'] = $this->uploadMedia($request->file('image'), 'portfolios');

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

        $validated['image_path'] = $this->uploadMedia($request->file('image'), 'portfolios', $portfolio->image_path);

        $portfolio->update($validated);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'نمونه‌کار بروزرسانی شد.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->deleteMedia($portfolio->image_path);

        $portfolio->delete();

        return back()->with('success', 'نمونه‌کار حذف شد.');
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
            'image'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_featured'    => ['nullable', 'boolean'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],
            'is_active'      => ['nullable', 'boolean'],
        ]);
    }
}
