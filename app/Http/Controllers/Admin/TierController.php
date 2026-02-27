<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TierController extends Controller
{
    public function __construct()
    {
        // Middleware already handled in routes/web.php
    }

    public function index()
    {
        $tiers = Tier::orderBy('created_at', 'desc')->get();
        return view('admin.tiers.index', compact('tiers'));
    }

    public function create()
    {
        return view('admin.tiers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'is_recommended' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle features array
        if ($request->has('features')) {
            $data['features'] = json_encode($request->features);
        }

        Tier::create($data);

        return redirect()->route('admin.tiers.index')->with('success', 'Tier created successfully.');
    }

    public function edit(Tier $tier)
    {
        return view('admin.tiers.edit', compact('tier'));
    }

    public function update(Request $request, Tier $tier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'is_recommended' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle features array
        if ($request->has('features')) {
            $data['features'] = json_encode($request->features);
        }

        $tier->update($data);

        return redirect()->route('admin.tiers.index')->with('success', 'Tier updated successfully.');
    }

    public function destroy(Tier $tier)
    {
        $tier->delete();

        return redirect()->route('admin.tiers.index')->with('success', 'Tier deleted successfully.');
    }
}
