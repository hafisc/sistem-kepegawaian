<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Village;
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
        
        // Mutasi Statistics (using Transfer model for mutasi data)
        $totalMutasi = 0;
        $pendingMutasi = 0;
        $approvedMutasi = 0;
        $completedMutasi = 0;
        
        // Monthly Mutasi Statistics (placeholder)
        $monthlyTransfers = collect();
        
        // Mutasi Status Distribution (placeholder)
        $transferStatusStats = collect();
        
        // Recent Mutasi (placeholder)
        $recentTransfers = collect();
        
        return view('admin.reports.index', compact(
            'totalEmployees', 'activeEmployees', 'inactiveEmployees',
            'totalVillages', 'activeVillages',
            'totalMutasi', 'pendingMutasi', 'approvedMutasi', 'completedMutasi',
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
     * Generate mutasi report.
     */
    public function transfers(Request $request)
    {
        // For now, return empty collection since we're using MutasiController
        // This can be enhanced to show mutasi data from Transfer model
        $transfers = collect()->paginate(20);
        
        return view('admin.reports.mutasi', compact('transfers'));
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
