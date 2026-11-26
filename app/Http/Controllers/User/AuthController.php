<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Harap centang kotak verifikasi captcha terlebih dahulu.',
                ]);
            }

            $response = Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key') ?? env('RECAPTCHA_SECRET_KEY'),
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip()
            ]);

            if (!$response->json('success')) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Validasi captcha gagal, silakan coba lagi.',
                ]);
            }

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                $user = Auth::user();
                if ($user->role === 'admin') {
                    return redirect()->intended('/admin/dashboard'); 
                }

                if ($user->role === 'umkm') {
                    return redirect()->intended('/toko');
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
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email ini sudah terdaftar.',
                'password.required' => 'Kata sandi wajib diisi.',
                'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            ]);

            $recaptchaResponse = $request->input('g-recaptcha-response');
            
            if (empty($recaptchaResponse)) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Harap centang kotak verifikasi captcha terlebih dahulu.',
                ]);
            }

            $response = Http::withoutVerifying()->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key') ?? env('RECAPTCHA_SECRET_KEY'),
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip()
            ]);

            if (!$response->json('success')) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Validasi captcha gagal, silakan coba lagi.',
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
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

    /**
     * Menampilkan antarmuka permohonan reset kata sandi (Lupa Password).
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Memproses pengajuan reset kata sandi dan menghasilkan token verifikasi.
     */
    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withInput()->withErrors([
                'email' => 'Alamat email tidak terdaftar dalam sistem Pojok UMKM Wonogiri.',
            ])->with('form', 'forgot');
        }

        // Buat token reset acak 64 karakter
        $token = Str::random(64);

        // Simpan token ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Langsung arahkan ke halaman pembuatan password baru dengan token valid
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ])->with('status', "Identitas akun atas nama '{$user->name}' berhasil diverifikasi. Silakan masukkan kata sandi baru Anda di bawah ini.");
    }

    /**
     * Menampilkan formulir pembuatan kata sandi baru.
     */
    public function showResetPassword(Request $request, $token)
    {
        $email = strtolower(trim((string)$request->query('email', '')));
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Permintaan reset kata sandi tidak ditemukan atau sudah kadaluarsa. Silakan masukkan email Anda kembali.',
            ]);
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.request')->withErrors([
                'email' => 'Tautan reset kata sandi telah kadaluarsa (melebihi batas waktu 60 menit). Silakan ajukan permohonan baru.',
            ]);
        }

        if (!Hash::check($token, $record->token) && $token !== $record->token) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Token verifikasi reset kata sandi tidak valid. Silakan ajukan permohonan baru.',
            ]);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Memproses penyimpanan kata sandi baru pengguna.
     */
    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'token.required' => 'Token reset kata sandi wajib disertakan.',
            'email.required' => 'Alamat email wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak sesuai.',
        ]);

        $email = strtolower(trim($request->email));
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Permintaan reset kata sandi tidak valid atau sudah digunakan.',
            ]);
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('password.request')->withErrors([
                'email' => 'Tautan reset kata sandi telah kadaluarsa. Silakan ajukan kembali.',
            ]);
        }

        if (!Hash::check($request->token, $record->token) && $request->token !== $record->token) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Token reset kata sandi tidak cocok atau tidak valid.',
            ]);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Akun pengguna tidak ditemukan dalam sistem.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token yang sudah digunakan
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi akun Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru.');
    }
}
