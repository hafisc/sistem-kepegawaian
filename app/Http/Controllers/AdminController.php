<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\NotifiesUsers;

class AdminController extends Controller
{
    use NotifiesUsers;
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Middleware is handled in routes
    }

    /**
     * Show the admin dashboard
     */
    public function dashboard()
    {
        // Total employees (excluding admin users)
        $totalPegawai = User::where('role', '!=', 'admin')->count();
        
        // Active employees
        $pegawaiAktif = User::where('role', '!=', 'admin')->where('is_active', true)->count();
        
        // Non-active employees
        $pegawaiNonAktif = User::where('role', '!=', 'admin')->where('is_active', false)->count();
        
        // Employee types
        $pns = User::where('role', '!=', 'admin')->where('employee_type', 'PNS')->count();
        $pppk = User::where('role', '!=', 'admin')->where('employee_type', 'PPPK')->count();
        $nonAsn = User::where('role', '!=', 'admin')->where('employee_type', 'NON ASN')->count();

        return view('admin.dashboard.dashboard', compact(
            'totalPegawai',
            'pegawaiAktif', 
            'pegawaiNonAktif',
            'pns',
            'pppk',
            'nonAsn'
        ));
    }

    /**
     * Show users management page
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Show enhanced create user form
     */
    public function createUserEnhanced()
    {
        $educations = \App\Models\Education::active()->get();
        $villages = \App\Models\Village::all();
        return view('admin.users.create-enhanced', compact('educations', 'villages'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $validation_rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user,camat',
        ];

        // Add enhanced validation if coming from enhanced form
        if ($request->has('nip') || $request->has('enhanced_form')) {
            $validation_rules = array_merge($validation_rules, [
                'nip' => 'nullable|string|unique:users',
                'nik' => 'nullable|string|unique:users',
                'gender' => 'nullable|in:L,P',
                'place_of_birth' => 'nullable|string|max:255',
                'date_of_birth' => 'nullable|date',
                'religion' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
                'marital_status' => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
                'address' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'employee_id' => 'nullable|string|unique:users',
                'employee_type' => 'nullable|in:PNS,PPPK,NON ASN',
                'position' => 'nullable|string|max:255',
                'rank' => 'nullable|string|max:255',
                'grade' => 'nullable|string|max:255',
                'work_unit' => 'nullable|string|max:255',
                'start_date' => 'nullable|date',
                'appointment_date' => 'nullable|date',
                'education_id' => 'nullable|exists:educations,id',
                'education_major' => 'nullable|string|max:255',
                'graduation_year' => 'nullable|integer|min:1950|max:' . date('Y'),
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sk_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:5120',
                'employment_status' => 'nullable|in:Aktif,Cuti,Pensiun,Mutasi,Nonaktif',
                'notes' => 'nullable|string',
                'village_id' => 'required|exists:villages,id',
            ]);
        }

        $request->validate($validation_rules);

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => true,
        ];

        // Add enhanced fields if present
        if ($request->has('nip') || $request->has('enhanced_form')) {
            $userData = array_merge($userData, $request->only([
                'nip', 'nik', 'gender', 'place_of_birth', 'date_of_birth', 'religion',
                'marital_status', 'address', 'phone', 'employee_id', 'employee_type',
                'position', 'rank', 'grade', 'work_unit', 'start_date', 'appointment_date',
                'education_id', 'education_major', 'graduation_year', 'employment_status', 
                'notes', 'village_id'
            ]));
        }

        $user = User::create($userData);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $photoPath]);
        }

        if ($request->hasFile('sk_file')) {
            $skPath = $request->file('sk_file')->store('documents', 'public');
            $user->update(['sk_file' => $skPath]);
        }

        // Create notification
        $this->notifyUserManagement($user, 'created');

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'is_active' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate.');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }
}
