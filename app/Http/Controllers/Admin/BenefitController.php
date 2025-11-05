<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
        $benefits = Benefit::orderBy('order')->get();
        return view('admin.benefits.index', compact('benefits'));
    }

    public function create()
    {
        return view('admin.benefits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        $validated['order'] = $validated['order'] ?? Benefit::max('order') + 1;

        Benefit::create($validated);

        return redirect()->route('admin.benefits')->with('success', 'Benefit created successfully');
    }

    public function edit(Benefit $benefit)
    {
        return view('admin.benefits.edit', compact('benefit'));
    }

    public function update(Request $request, Benefit $benefit)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer'
        ]);

        $benefit->update($validated);

        return redirect()->route('admin.benefits')->with('success', 'Benefit updated successfully');
    }

    public function destroy(Benefit $benefit)
    {
        $benefit->delete();
        return redirect()->route('admin.benefits')->with('success', 'Benefit deleted successfully');
    }
}
