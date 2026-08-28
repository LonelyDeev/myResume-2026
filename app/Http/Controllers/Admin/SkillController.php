<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $items = Skill::ordered()->get();

        return view('admin.skills.index', compact('items'));
    }

    public function create()
    {
        return view('admin.skills.form', ['item' => new Skill()]);
    }

    public function store(Request $request)
    {
        Skill::create($this->validated($request));

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'مهارت جدید اضافه شد.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.form', ['item' => $skill]);
    }

    public function update(Request $request, Skill $skill)
    {
        $skill->update($this->validated($request));

        return redirect()
            ->route('admin.skills.index')
            ->with('success', 'مهارت بروزرسانی شد.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return back()->with('success', 'مهارت حذف شد.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category'    => ['required', 'string', 'max:150'],
            'category_en' => ['nullable', 'string', 'max:150'],
            'name'        => ['required', 'string', 'max:150'],
            'name_en'     => ['nullable', 'string', 'max:150'],
            'level'       => ['nullable', 'integer', 'min:0', 'max:100'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);
    }
}
