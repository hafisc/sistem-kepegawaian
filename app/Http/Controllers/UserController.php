<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Transfer;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware is handled in routes
    }

    /**
     * Show the user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics for dashboard
        $totalEmployees = User::where('role', '!=', 'admin')->count();
        $totalTransfers = Transfer::count();
        $totalPNS = User::where('employee_type', 'PNS')->count();
        
        return view('user.dashboard.dashboard', compact('user', 'totalEmployees', 'totalTransfers', 'totalPNS'));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile.index', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diupdate.');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
        }

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('user.profile')->with('success', 'Password berhasil diubah.');
    }

    /**
     * Show employees list for user
     */
    public function employees(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filter by employee type
        if ($request->filled('employee_type')) {
            $query->where('employee_type', $request->employee_type);
        }

        // Filter by work unit
        if ($request->filled('work_unit')) {
            $query->where('work_unit', 'like', "%{$request->work_unit}%");
        }

        $employees = $query->latest()->paginate(15)->withQueryString();
        
        return view('user.employees.index', compact('employees'));
    }

    /**
     * Show transfers list for user
     */
    public function transfers(Request $request)
    {
        $query = Transfer::with(['employee', 'fromVillage', 'toVillage']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('employee', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                         ->orWhere('nip', 'like', "%{$search}%");
                })
                ->orWhere('from_unit', 'like', "%{$search}%")
                ->orWhere('to_unit', 'like', "%{$search}%")
                ->orWhere('reason', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by transfer type
        if ($request->filled('transfer_type')) {
            $query->where('transfer_type', $request->transfer_type);
        }

        $transfers = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        
        return view('user.transfers.index', compact('transfers'));
    }
}
