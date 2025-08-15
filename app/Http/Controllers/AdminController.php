<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Village;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
    public function users(Request $request)
    {
        $query = User::query();

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
            $query->where('work_unit', $request->work_unit);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        $villages = Village::where('is_active', true)->orderBy('name')->get();
        $educations = Education::orderBy('level')->get();
        $grades = \App\Models\Grade::where('is_active', true)->orderBy('code')->get();
        $ranks = \App\Models\Rank::where('is_active', true)->orderBy('code')->get();
        $religions = \App\Models\Religion::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.users.create', compact('villages', 'educations', 'grades', 'ranks', 'religions'));
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
            'role' => 'required|in:admin,user',
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
                'scan_ktp' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:2048',
                'scan_kk' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:2048',
                'scan_sk' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:10240',
                'sk_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:5120',
                'tanda_tangan_sk' => 'nullable|string|max:255',
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

        // Handle file uploads BEFORE redirect
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $photoPath]);
        }

        if ($request->hasFile('scan_ktp')) {
            $ktpPath = $request->file('scan_ktp')->store('documents', 'public');
            $user->update(['scan_ktp' => $ktpPath]);
        }

        if ($request->hasFile('scan_kk')) {
            $kkPath = $request->file('scan_kk')->store('documents', 'public');
            $user->update(['scan_kk' => $kkPath]);
        }

        if ($request->hasFile('scan_sk')) {
            $skPath = $request->file('scan_sk')->store('documents', 'public');
            $user->update(['scan_sk' => $skPath]);
        }

        if ($request->hasFile('sk_file')) {
            $skFilePath = $request->file('sk_file')->store('documents', 'public');
            $user->update(['sk_file' => $skFilePath]);
        }

        // Jika PNS maka arahkan ke form Mutasi Masuk
        if ($user->employee_type === 'PNS') {
            return redirect()->route('admin.mutasi.masuk', $user->id)
                ->with('success', 'Data pegawai berhasil disimpan. Silakan lengkapi Mutasi Masuk.');
        }

        // Create notification
        $this->notifyUserManagement($user, 'created');

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show user details
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        $educations = \App\Models\Education::active()->get();
        return view('admin.users.edit', compact('user', 'educations'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $validation_rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'nip' => 'nullable|string|unique:users,nip,' . $user->id,
            'nik' => 'nullable|string|unique:users,nik,' . $user->id,
            'gender' => 'nullable|in:L,P',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'religion' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'marital_status' => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'employee_id' => 'nullable|string|unique:users,employee_id,' . $user->id,
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
            'scan_ktp' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:2048',
            'scan_kk' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:2048',
            'scan_sk' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:10240',
            'employment_status' => 'nullable|in:Aktif,Cuti,Pensiun,Mutasi,Nonaktif',
            'notes' => 'nullable|string',
            'tanda_tangan_sk' => 'nullable|string|max:255',
        ];

        if ($request->filled('password')) {
            $validation_rules['password'] = 'string|min:8|confirmed';
        }

        $request->validate($validation_rules);

        $userData = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        // Add all other fields
        $userData = array_merge($userData, $request->only([
            'nip', 'nik', 'gender', 'place_of_birth', 'date_of_birth', 'religion',
            'marital_status', 'address', 'phone', 'employee_id', 'employee_type',
            'position', 'rank', 'grade', 'work_unit', 'start_date', 'appointment_date',
            'education_id', 'education_major', 'graduation_year', 'employment_status', 
            'notes', 'tanda_tangan_sk'
        ]));

        $user->update($userData);

        // Handle file uploads
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $photoPath]);
        }

        if ($request->hasFile('scan_ktp')) {
            if ($user->scan_ktp) {
                Storage::disk('public')->delete($user->scan_ktp);
            }
            $ktpPath = $request->file('scan_ktp')->store('documents', 'public');
            $user->update(['scan_ktp' => $ktpPath]);
        }

        if ($request->hasFile('scan_kk')) {
            if ($user->scan_kk) {
                Storage::disk('public')->delete($user->scan_kk);
            }
            $kkPath = $request->file('scan_kk')->store('documents', 'public');
            $user->update(['scan_kk' => $kkPath]);
        }

        if ($request->hasFile('scan_sk')) {
            if ($user->scan_sk) {
                Storage::disk('public')->delete($user->scan_sk);
            }
            $skPath = $request->file('scan_sk')->store('documents', 'public');
            $user->update(['scan_sk' => $skPath]);
        }

        // Update password if provided
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'Data pegawai berhasil diupdate.');
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
