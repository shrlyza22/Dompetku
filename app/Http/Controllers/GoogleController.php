<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Lempar user ke halaman login Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Nangkep user setelah balik dari Google
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Kalau emailnya udah terdaftar, tinggal update google_id-nya
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
        } else {
            // Kalau belum ada, bikin akun baru
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'password'          => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
            ]);

            // Isi kategori bawaan untuk user baru Google
            \App\Models\Category::seedDefaultsForUser($user->id);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}