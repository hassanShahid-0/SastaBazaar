<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::withCount(['listings', 'orders'])->latest()->paginate(15);
        return view('admin.shops.index', compact('shops'));
    }

    public function create()
    {
        return view('admin.shops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string|max:500',
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Shop::create($validated);

        return redirect()->route('admin.shops.index')
            ->with('success', 'Shop created successfully.');
    }

    public function edit(Shop $shop)
    {
        return view('admin.shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string|max:500',
            'is_active'  => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $shop->update($validated);

        return redirect()->route('admin.shops.index')
            ->with('success', 'Shop updated successfully.');
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('admin.shops.index')
            ->with('success', 'Shop deleted.');
    }

    /**
     * Toggle the verified status of a shop.
     */
    public function verify(Shop $shop)
    {
        $shop->update(['is_verified' => ! $shop->is_verified]);
        $status = $shop->is_verified ? 'verified' : 'unverified';
        return redirect()->back()
            ->with('success', "Shop \"{$shop->name}\" has been {$status}.");
    }
}
