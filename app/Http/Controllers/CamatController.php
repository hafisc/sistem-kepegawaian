<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Village;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\NotifiesUsers;

class CamatController extends Controller
{
    use NotifiesUsers;

    /**
     * Show the camat dashboard
     */
    public function dashboard()
    {
        $totalEmployees = User::where('role', '!=', 'admin')->count();
        $activeEmployees = User::where('role', '!=', 'admin')->where('is_active', true)->count();
        $totalVillages = Village::count();
        $activeVillages = Village::where('is_active', true)->count();
        $pendingTransfers = Transfer::where('status', 'pending')->count();
        $recentTransfers = Transfer::with(['employee', 'fromVillage', 'toVillage'])
            ->latest()
            ->limit(5)
            ->get();

        return view('camat.dashboard', compact(
            'totalEmployees',
            'activeEmployees', 
            'totalVillages',
            'activeVillages',
            'pendingTransfers',
            'recentTransfers'
        ));
    }

    /**
     * Display employees under camat supervision
     */
    public function employees()
    {
        $employees = User::where('role', '!=', 'admin')
            ->with('education')
            ->orderBy('name')
            ->paginate(20);

        return view('camat.employees.index', compact('employees'));
    }

    /**
     * Show employee details
     */
    public function showEmployee(User $employee)
    {
        if ($employee->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $employee->load('education');
        return view('camat.employees.show', compact('employee'));
    }

    /**
     * Display villages under camat supervision
     */
    public function villages()
    {
        $villages = Village::orderBy('name')->paginate(20);
        return view('camat.villages.index', compact('villages'));
    }

    /**
     * Show village details
     */
    public function showVillage(Village $village)
    {
        $employees = User::where('work_unit', 'like', '%' . $village->name . '%')
            ->where('role', '!=', 'admin')
            ->with('education')
            ->get();

        return view('camat.villages.show', compact('village', 'employees'));
    }

    /**
     * Display transfers under camat supervision
     */
    public function transfers()
    {
        $transfers = Transfer::with(['employee', 'fromVillage', 'toVillage'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('camat.transfers.index', compact('transfers'));
    }

    /**
     * Show transfer details
     */
    public function showTransfer(Transfer $transfer)
    {
        $transfer->load(['employee', 'fromVillage', 'toVillage']);
        return view('camat.transfers.show', compact('transfer'));
    }

    /**
     * Approve transfer (camat can approve certain transfers)
     */
    public function approveTransfer(Transfer $transfer)
    {
        if ($transfer->status !== 'pending') {
            return redirect()->back()->with('error', 'Transfer tidak dapat disetujui karena status sudah berubah.');
        }

        $transfer->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        $this->notifyTransfer($transfer, 'approved');

        return redirect()->back()->with('success', 'Transfer berhasil disetujui.');
    }

    /**
     * Reject transfer
     */
    public function rejectTransfer(Request $request, Transfer $transfer)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        if ($transfer->status !== 'pending') {
            return redirect()->back()->with('error', 'Transfer tidak dapat ditolak karena status sudah berubah.');
        }

        $transfer->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'notes' => $request->rejection_reason
        ]);

        $this->notifyTransfer($transfer, 'rejected');

        return redirect()->back()->with('success', 'Transfer berhasil ditolak.');
    }

    /**
     * Generate reports for camat
     */
    public function reports()
    {
        $employeeStats = [
            'total' => User::where('role', '!=', 'admin')->count(),
            'active' => User::where('role', '!=', 'admin')->where('is_active', true)->count(),
            'pns' => User::where('employee_type', 'PNS')->count(),
            'pppk' => User::where('employee_type', 'PPPK')->count(),
            'non_asn' => User::where('employee_type', 'NON ASN')->count(),
        ];

        $transferStats = [
            'total' => Transfer::count(),
            'pending' => Transfer::where('status', 'pending')->count(),
            'approved' => Transfer::where('status', 'approved')->count(),
            'completed' => Transfer::where('status', 'completed')->count(),
            'rejected' => Transfer::where('status', 'rejected')->count(),
        ];

        $villageStats = [
            'total' => Village::count(),
            'active' => Village::where('is_active', true)->count(),
        ];

        return view('camat.reports.index', compact('employeeStats', 'transferStats', 'villageStats'));
    }
}
