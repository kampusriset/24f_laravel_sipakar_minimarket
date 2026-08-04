<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    $user = Socialite::driver('google')->user();

    // contoh: simpan atau login user
    $existingUser = User::where('email', $user->getEmail())->first();

    if ($existingUser) {
        Auth::login($existingUser);
    } else {
        User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'google_id' => $user->getId(),
        ]);
    }

    return redirect('/dashboard');
}


    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            Log::error('Login Google gagal: ' . $e->getMessage());

            return redirect()->route('login')->withErrors([
                'email' => 'Login dengan Google gagal, silakan coba lagi.',
            ]);
        }

        // Cari user berdasarkan google_id lebih dulu, lalu fallback ke email
        // (mengaitkan akun lama yang dibuat manual dengan akun Google-nya).
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            if (! $user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        } else {
            // Akun baru dari Google otomatis diberi role "kasir" (kebijakan sama
            // dengan pendaftaran manual). Admin tetap harus dibuat lewat seeder/CRUD Kasir.
            $user = User::create([
                'name' => $googleUser->getName() ?: $googleUser->getNickname(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(32)),
                'role' => 'kasir',
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]);
        }

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
