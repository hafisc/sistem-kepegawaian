<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PositionHistory;
use Illuminate\Http\Request;

class PositionHistoryController extends Controller
{
    /**
     * Show position history for a user
     */
    public function index(User $user)
    {
        $positionHistories = $user->positionHistories()->paginate(10);
        return view('admin.position-history.index', compact('user', 'positionHistories'));
    }

    /**
     * Show form to create new position history
     */
    public function create(User $user)
    {
        return view('admin.position-history.create', compact('user'));
    }

    /**
     * Store new position history
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
            'position_level' => 'nullable|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'sk_number' => 'nullable|string|max:255',
            'sk_date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,selesai',
            'notes' => 'nullable|string',
        ]);

        // If this is an active position, set other positions to completed
        if ($request->status === 'aktif') {
            $user->positionHistories()->where('status', 'aktif')->update(['status' => 'selesai']);
        }

        $user->positionHistories()->create($request->all());

        return redirect()->route('admin.position-history.index', $user)
            ->with('success', 'Riwayat jabatan berhasil ditambahkan.');
    }

    /**
     * Show form to edit position history
     */
    public function edit(User $user, PositionHistory $positionHistory)
    {
        return view('admin.position-history.edit', compact('user', 'positionHistory'));
    }

    /**
     * Update position history
     */
    public function update(Request $request, User $user, PositionHistory $positionHistory)
    {
        $request->validate([
            'position_name' => 'required|string|max:255',
            'position_level' => 'nullable|string|max:255',
            'unit_kerja' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'sk_number' => 'nullable|string|max:255',
            'sk_date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'required|in:aktif,selesai',
            'notes' => 'nullable|string',
        ]);

        // If this is being set to active, set other positions to completed
        if ($request->status === 'aktif' && $positionHistory->status !== 'aktif') {
            $user->positionHistories()->where('status', 'aktif')->where('id', '!=', $positionHistory->id)->update(['status' => 'selesai']);
        }

        $positionHistory->update($request->all());

        return redirect()->route('admin.position-history.index', $user)
            ->with('success', 'Riwayat jabatan berhasil diupdate.');
    }

    /**
     * Delete position history
     */
    public function destroy(User $user, PositionHistory $positionHistory)
    {
        $positionHistory->delete();

        return redirect()->route('admin.position-history.index', $user)
            ->with('success', 'Riwayat jabatan berhasil dihapus.');
    }
}
