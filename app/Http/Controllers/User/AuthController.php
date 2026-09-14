<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan antarmuka autentikasi pada state default (Login).
     */
    public function showLogin()
    {
        return view('auth.index', ['isRegister' => false]);
    }

    /**
     * Memproses logika validasi dan autentikasi kredensial pengguna.
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                $user = Auth::user();
                if ($user->role === 'admin' || $user->role === 'umkm') {
                    return redirect()->intended('/admin/dashboard'); 
                }
                
                return redirect()->intended('/');
            }

            throw ValidationException::withMessages([
                'email' => 'Kredensial email atau kata sandi tidak ditemukan dalam sistem.',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()->with('form', 'login');
        }
    }

    /**
     * Menampilkan antarmuka autentikasi pada state registrasi.
     */
    public function showRegister()
    {
        return view('auth.index', ['isRegister' => true]);
    }

    /**
     * Memproses logika validasi dan penambahan entitas pengguna baru ke dalam basis data.
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'in:user,umkm'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            Auth::login($user);

            return redirect('/');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()->with('form', 'register');
        }
    }

    /**
     * Memproses logika pemutusan akses autentikasi pengguna (Logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
