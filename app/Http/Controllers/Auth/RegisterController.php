<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Pendaftaran mandiri HANYA menghasilkan akun dengan role "kasir".
     * Akun "admin" sengaja tidak bisa dibuat lewat form publik ini —
     * dibuat lewat seeder (lihat UserSeeder Fase 1) atau oleh admin lain
     * lewat menu CRUD Kasir (Fase 4), supaya hak akses admin terkontrol.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'kasir',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
