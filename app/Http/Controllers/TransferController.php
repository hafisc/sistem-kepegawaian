<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    /**
     * Display a listing of transfers.
     */
    public function index()
    {
        $transfers = Transfer::with(['employee', 'fromVillage', 'toVillage'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new transfer.
     */
    public function create()
    {
        $employees = User::where('role', 'user')->where('is_active', true)->get();
        $villages = Village::where('is_active', true)->get();
        
        return view('admin.transfers.create', compact('employees', 'villages'));
    }

    /**
     * Store a newly created transfer in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:users,id',
            'from_village_id' => 'required|exists:villages,id',
            'to_village_id' => 'required|exists:villages,id|different:from_village_id',
            'transfer_date' => 'required|date',
            'effective_date' => 'required|date|after_or_equal:transfer_date',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Transfer::create([
            'employee_id' => $request->employee_id,
            'from_village_id' => $request->from_village_id,
            'to_village_id' => $request->to_village_id,
            'transfer_date' => $request->transfer_date,
            'effective_date' => $request->effective_date,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.transfers')
            ->with('success', 'Data mutasi berhasil ditambahkan!');
    }

    /**
     * Display the specified transfer.
     */
    public function show(Transfer $transfer)
    {
        $transfer->load(['employee', 'fromVillage', 'toVillage']);
        return view('admin.transfers.show', compact('transfer'));
    }

    /**
     * Show the form for editing the specified transfer.
     */
    public function edit(Transfer $transfer)
    {
        $employees = User::where('role', 'user')->where('is_active', true)->get();
        $villages = Village::where('is_active', true)->get();
        
        return view('admin.transfers.edit', compact('transfer', 'employees', 'villages'));
    }

    /**
     * Update the specified transfer in storage.
     */
    public function update(Request $request, Transfer $transfer)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:users,id',
            'from_village_id' => 'required|exists:villages,id',
            'to_village_id' => 'required|exists:villages,id|different:from_village_id',
            'transfer_date' => 'required|date',
            'effective_date' => 'required|date|after_or_equal:transfer_date',
            'reason' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $transfer->update([
            'employee_id' => $request->employee_id,
            'from_village_id' => $request->from_village_id,
            'to_village_id' => $request->to_village_id,
            'transfer_date' => $request->transfer_date,
            'effective_date' => $request->effective_date,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.transfers')
            ->with('success', 'Data mutasi berhasil diperbarui!');
    }

    /**
     * Remove the specified transfer from storage.
     */
    public function destroy(Transfer $transfer)
    {
        try {
            $transfer->delete();
            return redirect()->route('admin.transfers')
                ->with('success', 'Data mutasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.transfers')
                ->with('error', 'Gagal menghapus data mutasi.');
        }
    }

    /**
     * Update transfer status.
     */
    public function updateStatus(Request $request, Transfer $transfer)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,completed',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $transfer->update([
            'status' => $request->status,
            'notes' => $request->notes ?? $transfer->notes,
        ]);

        return redirect()->back()
            ->with('success', 'Status mutasi berhasil diperbarui!');
    }
}
