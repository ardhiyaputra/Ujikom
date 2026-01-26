<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function loginSiswa(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'email' => 'nullable|email',
        ]);

        session([
            'siswa_logged_in' => true,
            'siswa_nama' => $request->nama_siswa,
            'siswa_kelas' => $request->kelas,
            'siswa_email' => $request->email,
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Selamat datang, ' . $request->nama_siswa . '!');
    }

    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }

    public function logoutSiswa()
    {
        session()->forget(['siswa_logged_in', 'siswa_nama', 'siswa_kelas', 'siswa_email']);
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}