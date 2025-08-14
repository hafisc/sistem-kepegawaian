<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Religion;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Religion::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $religions = $query->orderBy('name')->paginate(15)->withQueryString();
        
        return view('admin.religions.index', compact('religions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:religions,name|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Religion::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.religions.index')
                        ->with('success', 'Agama berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Religion $religion)
    {
        $request->validate([
            'name' => 'required|string|unique:religions,name,' . $religion->id . '|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $religion->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.religions.index')
                        ->with('success', 'Agama berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Religion $religion)
    {
        $religion->delete();
        
        return redirect()->route('admin.religions.index')
                        ->with('success', 'Agama berhasil dihapus.');
    }
}
