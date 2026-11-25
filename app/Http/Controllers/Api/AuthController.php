<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // 1. Endpoint Login untuk Mendapatkan Token Sesi
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan passwordnya cocok
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // Hapus token lama jika ingin 1 user hanya punya 1 sesi aktif
        // $user->tokens()->delete();

        // Buat Token Sesi Baru
        $token = $user->createToken('api_session_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'token'   => $token,
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role, // student, organizer, atau admin
                'npm'   => $user->npm,
                'major' => $user->major,
            ]
        ], 200);
    }

    // 2. Endpoint Cek Sesi (Melihat Data User yang Sedang Login)
    public function session(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Sesi aktif ditemukan.',
            'user'    => $request->user()
        ], 200);
    }

    // 3. Endpoint Logout (Menghapus Sesi / Token)
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan untuk request ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesi telah berakhir (Logout berhasil).'
        ], 200);
    }
}