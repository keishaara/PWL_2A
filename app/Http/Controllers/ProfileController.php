<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('mahasiswa.profil', compact('user'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'        => ['nullable', 'string', 'max:20'],
            'major'        => ['nullable', 'string', 'max:100'],
            'semester'     => ['nullable', 'integer', 'min:1', 'max:14'],
            'foto_profil'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.unique'        => 'Email sudah digunakan oleh akun lain.',
            'semester.min'        => 'Semester minimal 1.',
            'semester.max'        => 'Semester maksimal 14.',
            'foto_profil.image'   => 'Berkas foto profil harus berupa gambar.',
            'foto_profil.mimes'   => 'Format foto profil harus JPG, JPEG, atau PNG.',
            'foto_profil.max'     => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($user->avatar && file_exists(public_path('uploads/profiles/' . $user->avatar))) {
                @unlink(public_path('uploads/profiles/' . $user->avatar));
            }

            $file = $request->file('foto_profil');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profiles');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);
            $user->avatar = $fileName;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->major = $validated['major'] ?? null;
        $user->semester = $validated['semester'] ?? null;

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.required'         => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi lama yang Anda masukkan tidak sesuai.',
            'password.required'                 => 'Kata sandi baru wajib diisi.',
            'password.confirmed'                => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')->with('success_password', 'Kata sandi berhasil diperbarui!');
    }
}
