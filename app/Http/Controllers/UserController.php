<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan semua user.
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('user.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,customer,designer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;

        // Upload foto
        if ($request->hasFile('foto')) {

            $foto = $request->file('foto');

            $namaFoto = time() . '_' . $foto->getClientOriginalName();

            $foto->move(
                public_path('uploads/users'),
                $namaFoto
            );

            $user->foto = $namaFoto;
        }

        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Mengupdate user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,customer,designer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;

        // Jika password diisi, update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($user->foto) {

                $fotoLama = public_path(
                    'uploads/users/' . $user->foto
                );

                if (file_exists($fotoLama)) {
                    unlink($fotoLama);
                }
            }

            $foto = $request->file('foto');

            $namaFoto = time() . '_' . $foto->getClientOriginalName();

            $foto->move(
                public_path('uploads/users'),
                $namaFoto
            );

            $user->foto = $namaFoto;
        }

        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus foto jika ada
        if ($user->foto) {

            $path = public_path(
                'uploads/users/' . $user->foto
            );

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
