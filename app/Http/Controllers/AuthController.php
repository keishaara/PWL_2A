<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

     public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);
        $remember = $request->boolean('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'organizer') {
                return redirect()->intended('/organisasi/dashboard');
            }
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'tipe'                => ['required', 'in:mahasiswa,organisasi'],
            'nama'                => ['required', 'string', 'max:255'],
            'email'               => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'npm'                 => ['required_if:tipe,mahasiswa', 'nullable', 'string', 'max:20', 'unique:users,npm'],
            'program_studi'       => ['required_if:tipe,mahasiswa', 'nullable', 'string', 'max:255'],
            'wa'                  => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,12}$/'],
            'password'            => ['required', 'string', 'min:8', 'same:konfirmasi_password'],
            'konfirmasi_password' => ['required'],
        ], [
            'tipe.required'             => 'Pilih jenis akun terlebih dahulu.',
            'tipe.in'                   => 'Jenis akun tidak valid.',
            'nama.required'             => 'Nama wajib diisi.',
            'nama.max'                  => 'Nama maksimal 255 karakter.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.max'                 => 'Email maksimal 255 karakter.',
            'email.unique'              => 'Email ini sudah terdaftar. Silakan masuk.',
            'npm.required_if'           => 'NPM wajib diisi untuk mahasiswa.',
            'npm.max'                   => 'NPM maksimal 20 karakter.',
            'npm.unique'                => 'NPM ini sudah terdaftar.',
            'program_studi.required_if' => 'Program studi wajib diisi untuk mahasiswa.',
            'program_studi.max'         => 'Program studi maksimal 255 karakter.',
            'wa.required'               => 'Nomor WhatsApp wajib diisi.',
            'wa.regex'                  => 'Format nomor WhatsApp tidak valid (contoh: 081234567890).',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'password.same'             => 'Password dan konfirmasi password tidak sama.',
            'konfirmasi_password.required' => 'Konfirmasi password wajib diisi.',
        ]);

        $isMahasiswa = $validated['tipe'] === 'mahasiswa';

        // dua tabel diisi sekaligus, kalau salah satunya gagal, dua-duanya dibatalkan
        DB::transaction(function () use ($validated, $isMahasiswa) {
            $user = User::create([
                'name'     => $validated['nama'],
                'email'    => $validated['email'],
                'password' => $validated['password'], // otomatis di-hash oleh cast di model User
                'role'     => $isMahasiswa ? 'student' : 'organizer',
                'npm'      => $isMahasiswa ? $validated['npm'] : null,
                'major'    => $isMahasiswa ? $validated['program_studi'] : null,
                'phone'    => $validated['wa'],
            ]);

            if (! $isMahasiswa) {
                Organization::create([
                    'user_id' => $user->id,
                    'name'    => $validated['nama'],
                ]);
            }
        });

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }
}