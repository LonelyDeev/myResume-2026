<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $items = Education::ordered()->get();

        return view('admin.educations.index', compact('items'));
    }

    public function create()
    {
        return view('admin.educations.form', ['item' => new Education()]);
    }

    public function store(Request $request)
    {
        Education::create($this->validated($request));

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'مورد تحصیلی جدید اضافه شد.');
    }

    public function edit(Education $education)
    {
        return view('admin.educations.form', ['item' => $education]);
    }

    public function update(Request $request, Education $education)
    {
        $education->update($this->validated($request));

        return redirect()
            ->route('admin.educations.index')
            ->with('success', 'مورد تحصیلی بروزرسانی شد.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return back()->with('success', 'مورد تحصیلی حذف شد.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'degree'         => ['required', 'string', 'max:200'],
            'degree_en'      => ['nullable', 'string', 'max:200'],
            'institution'    => ['required', 'string', 'max:250'],
            'institution_en' => ['nullable', 'string', 'max:250'],
            'period'         => ['nullable', 'string', 'max:150'],
            'period_en'      => ['nullable', 'string', 'max:150'],
            'description'    => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],
            'is_active'      => ['nullable', 'boolean'],
        ]);
    }
}
