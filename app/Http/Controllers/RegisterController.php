<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Menampilkan form registrasi
    public function showRegister()
    {
        return view('auth.register');
    }

    // Memproses data registrasi
    public function register(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' butuh input password_confirmation
        ]);

        // 2. Simpan ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Default role untuk pendaftar baru adalah customer
        ]);

        // 3. Login otomatis setelah daftar
        Auth::login($user);

        // 4. Redirect ke halaman dashboard customer
        return redirect()->route('customer.dashboard')->with('success', 'Registrasi berhasil!');
    }
}