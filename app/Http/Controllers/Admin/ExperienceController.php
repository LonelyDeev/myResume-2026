<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $items = Experience::ordered()->get();

        return view('admin.experiences.index', compact('items'));
    }

    public function create()
    {
        return view('admin.experiences.form', ['item' => new Experience()]);
    }

    public function store(Request $request)
    {
        Experience::create($this->validated($request));

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'تجربه کاری جدید اضافه شد.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.form', ['item' => $experience]);
    }

    public function update(Request $request, Experience $experience)
    {
        $experience->update($this->validated($request));

        return redirect()
            ->route('admin.experiences.index')
            ->with('success', 'تجربه کاری بروزرسانی شد.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return back()->with('success', 'تجربه کاری حذف شد.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'position'       => ['required', 'string', 'max:200'],
            'position_en'    => ['nullable', 'string', 'max:200'],
            'company'        => ['required', 'string', 'max:250'],
            'company_en'     => ['nullable', 'string', 'max:250'],
            'period'         => ['required', 'string', 'max:150'],
            'period_en'      => ['nullable', 'string', 'max:150'],
            'is_current'     => ['nullable', 'boolean'],
            'description'    => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],
            'is_active'      => ['nullable', 'boolean'],
        ]);
    }
}
