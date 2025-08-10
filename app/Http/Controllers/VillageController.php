<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Village;
use Illuminate\Support\Facades\Validator;

class VillageController extends Controller
{
    /**
     * Display a listing of villages.
     */
    public function index()
    {
        $villages = Village::paginate(10);
        return view('admin.villages.index', compact('villages'));
    }

    /**
     * Show the form for creating a new village.
     */
    public function create()
    {
        return view('admin.villages.create');
    }

    /**
     * Store a newly created village in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:villages,name',
            'code' => 'required|string|max:20|unique:villages,code',
            'district' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Village::create([
            'name' => $request->name,
            'code' => $request->code,
            'district' => $request->district,
            'regency' => $request->regency,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.villages')
            ->with('success', 'Desa berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified village.
     */
    public function edit(Village $village)
    {
        return view('admin.villages.edit', compact('village'));
    }

    /**
     * Update the specified village in storage.
     */
    public function update(Request $request, Village $village)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:villages,name,' . $village->id,
            'code' => 'required|string|max:20|unique:villages,code,' . $village->id,
            'district' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $village->update([
            'name' => $request->name,
            'code' => $request->code,
            'district' => $request->district,
            'regency' => $request->regency,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.villages')
            ->with('success', 'Desa berhasil diperbarui!');
    }

    /**
     * Remove the specified village from storage.
     */
    public function destroy(Village $village)
    {
        try {
            $village->delete();
            return redirect()->route('admin.villages')
                ->with('success', 'Desa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.villages')
                ->with('error', 'Gagal menghapus desa. Pastikan tidak ada data terkait.');
        }
    }
}
