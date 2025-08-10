<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Village;
use App\Models\Transfer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display the main reports dashboard.
     */
    public function index()
    {
        // Employee Statistics
        $totalEmployees = User::where('role', 'user')->count();
        $activeEmployees = User::where('role', 'user')->where('is_active', true)->count();
        $inactiveEmployees = User::where('role', 'user')->where('is_active', false)->count();
        
        // Village Statistics
        $totalVillages = Village::count();
        $activeVillages = Village::where('is_active', true)->count();
        
        // Transfer Statistics
        $totalTransfers = Transfer::count();
        $pendingTransfers = Transfer::where('status', 'pending')->count();
        $approvedTransfers = Transfer::where('status', 'approved')->count();
        $completedTransfers = Transfer::where('status', 'completed')->count();
        
        // Monthly Transfer Statistics (Last 6 months)
        $monthlyTransfers = Transfer::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
        
        // Transfer Status Distribution
        $transferStatusStats = Transfer::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();
        
        // Recent Transfers
        $recentTransfers = Transfer::with(['employee', 'fromVillage', 'toVillage'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.reports.index', compact(
            'totalEmployees', 'activeEmployees', 'inactiveEmployees',
            'totalVillages', 'activeVillages',
            'totalTransfers', 'pendingTransfers', 'approvedTransfers', 'completedTransfers',
            'monthlyTransfers', 'transferStatusStats', 'recentTransfers'
        ));
    }

    /**
     * Generate employee report.
     */
    public function employees(Request $request)
    {
        $query = User::where('role', 'user');
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $employees = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.reports.employees', compact('employees'));
    }

    /**
     * Generate village report.
     */
    public function villages(Request $request)
    {
        $query = Village::query();
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Filter by province
        if ($request->has('province') && $request->province) {
            $query->where('province', 'like', '%' . $request->province . '%');
        }
        
        $villages = $query->orderBy('created_at', 'desc')->paginate(20);
        $provinces = Village::select('province')->distinct()->pluck('province');
        
        return view('admin.reports.villages', compact('villages', 'provinces'));
    }

    /**
     * Generate transfer report.
     */
    public function transfers(Request $request)
    {
        $query = Transfer::with(['employee', 'fromVillage', 'toVillage']);
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('transfer_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('transfer_date', '<=', $request->date_to);
        }
        
        // Filter by employee
        if ($request->has('employee') && $request->employee) {
            $query->whereHas('employee', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->employee . '%');
            });
        }
        
        $transfers = $query->orderBy('transfer_date', 'desc')->paginate(20);
        
        return view('admin.reports.transfers', compact('transfers'));
    }

    /**
     * Export employee data to CSV.
     */
    public function exportEmployees()
    {
        $employees = User::where('role', 'user')->get();
        
        $filename = 'laporan_pegawai_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($employees) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, ['No', 'Nama', 'Username', 'Email', 'Status', 'Dibuat']);
            
            // Data
            foreach ($employees as $index => $employee) {
                fputcsv($file, [
                    $index + 1,
                    $employee->name,
                    $employee->username,
                    $employee->email,
                    $employee->is_active ? 'Aktif' : 'Nonaktif',
                    $employee->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
