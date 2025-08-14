<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');
        
        // Find user by username
        $user = User::where('username', $credentials['username'])->first();
        
        if (!$user) {
            throw ValidationException::withMessages([
                'login' => 'Username atau password salah.',
            ]);
        }

        // Check if user is active
        if (!$user->isActive()) {
            throw ValidationException::withMessages([
                'login' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ]);
        }

        // Verify password
        if (!Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => 'Username atau password salah.',
            ]);
        }

        // Login the user
        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();

        return $this->redirectBasedOnRole();
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
}
