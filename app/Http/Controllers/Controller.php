<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLogin() {
        return view('auth.login');
    }

    // Proses Login (Sesuai Flowchart: Validasi Login)
    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect sesuai role (flowchart admin vs siswa)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/siswa/dashboard');
        }

        // Jika login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Proses daftar anggota (sesuai flowchart: "Daftar Anggota")
    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'nama_lengkap' => 'required'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // ← diperbaiki: sebelumnya pakai nama_lengkap
            'nama_lengkap' => $request->nama_lengkap,     // ← tambahkan ini jika ada kolom nama_lengkap di tabel users
            'role' => 'siswa' // Default register adalah siswa
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar, silahkan login!'); // ← diperbaiki: 'succes' → 'success'
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();     // ← diperbaiki: sessions() → session()
        $request->session()->regenerateToken(); // ← diperbaiki: sessions() → session()
        return redirect('/login');
    }
}