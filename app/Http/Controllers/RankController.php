<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rank;
use App\Models\Grade;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rank::with('grade');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $ranks = $query->orderBy('grade_code')->orderBy('code')->paginate(15)->withQueryString();
        $grades = Grade::where('is_active', true)->orderBy('code')->get();
        
        return view('admin.ranks.index', compact('ranks', 'grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:ranks,code',
            'name' => 'required|string|max:255',
            'grade_code' => 'required|exists:grades,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        Rank::create([
            'code' => $request->code,
            'name' => $request->name,
            'grade_code' => $request->grade_code,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.ranks.index')
                        ->with('success', 'Pangkat berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rank $rank)
    {
        $request->validate([
            'code' => 'required|string|unique:ranks,code,' . $rank->id,
            'name' => 'required|string|max:255',
            'grade_code' => 'required|exists:grades,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $rank->update([
            'code' => $request->code,
            'name' => $request->name,
            'grade_code' => $request->grade_code,
            'description' => $request->description,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.ranks.index')
                        ->with('success', 'Pangkat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rank $rank)
    {
        $rank->delete();
        
        return redirect()->route('admin.ranks.index')
                        ->with('success', 'Pangkat berhasil dihapus.');
    }
}
