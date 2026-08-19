<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use Illuminate\Http\Request;

class CommodityController extends Controller
{
    public function index()
    {
        $commodities = Commodity::orderBy('name')->paginate(15);
        return view('admin.commodities.index', compact('commodities'));
    }

    public function create()
    {
        return view('admin.commodities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:commodities,name',
            'urdu_name' => 'nullable|string|max:255',
            'unit'      => 'required|string|max:50',
        ]);
        Commodity::create($validated);
        return redirect()->route('admin.commodities.index')
            ->with('success', 'Commodity added successfully.');
    }

    public function edit(Commodity $commodity)
    {
        return view('admin.commodities.edit', compact('commodity'));
    }

    public function update(Request $request, Commodity $commodity)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:commodities,name,' . $commodity->id,
            'urdu_name' => 'nullable|string|max:255',
            'unit'      => 'required|string|max:50',
        ]);
        $commodity->update($validated);
        return redirect()->route('admin.commodities.index')
            ->with('success', 'Commodity updated successfully.');
    }

    public function destroy(Commodity $commodity)
    {
        $commodity->delete();
        return redirect()->route('admin.commodities.index')
            ->with('success', 'Commodity deleted successfully.');
    }
}
