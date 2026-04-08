<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar anggota (Hanya role '')
    public function index()
    {
        $users = User::where('role', 'siswa')->get();
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form tambah anggota
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan anggota baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'nullable'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Enkripsi password manual
            'alamat' => $request->alamat,
            'role' => 'siswa' // Default role anggota

        ]);

        return redirect()->route('user.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit (string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // Update data anggota
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'alamat' => 'nullable'
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'alamat' => $request->alamat,
        ];

        // Cek jika admin mengisi password baru (jika kosong, jangan diupdate)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data anggota diperbarui');
    }

    // Hapus anggota
    public function destroy(string $id)
    {
        $user =User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Anggota berhasil dihapus');
    }
}
