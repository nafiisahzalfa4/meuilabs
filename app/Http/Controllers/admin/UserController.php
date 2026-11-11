<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function checkAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->role == 'admin', 403);
    }

    // Menampilkan semua user
    public function index()
    {
        $this->checkAdmin();

        $users = User::latest()->get();

        return view('admin.user.index', compact('users'));
    }

    // Form tambah user
    public function create()
    {
        $this->checkAdmin();

        return view('admin.user.create');
    }

    // Menyimpan user
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,customer,designer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;

        if ($request->hasFile('foto')) {
            $folder = public_path('uploads/users');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $foto = $request->file('foto');

            $namaFoto = time() . '_' .
                preg_replace('/\s+/', '_', $foto->getClientOriginalName());

            $foto->move($folder, $namaFoto);

            $user->foto = $namaFoto;
        }

        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    // Form edit user
    public function edit($id)
    {
        $this->checkAdmin();

        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,customer,designer',
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->no_telepon = $request->no_telepon;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $folder = public_path('uploads/users');

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            if ($user->foto) {
                $fotoLama = $folder . '/' . $user->foto;

                if (File::exists($fotoLama)) {
                    File::delete($fotoLama);
                }
            }

            $foto = $request->file('foto');

            $namaFoto = time() . '_' .
                preg_replace('/\s+/', '_', $foto->getClientOriginalName());

            $foto->move($folder, $namaFoto);

            $user->foto = $namaFoto;
        }

        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy($id)
    {
        $this->checkAdmin();

        $user = User::findOrFail($id);

        if ($user->id == auth()->id()) {
            return back()->with(
                'error',
                'Kamu tidak dapat menghapus akun yang sedang digunakan.'
            );
        }

        if ($user->foto) {
            $path = public_path('uploads/users/' . $user->foto);

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}