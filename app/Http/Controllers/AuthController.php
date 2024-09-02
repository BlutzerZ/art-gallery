<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        else {
            return view('auth.login', [
                'title' => "login"
            ]);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        $response = Http::post('https://api.dinus.ac.id/api/v1/siadin/login', [
            'username' => $request->nim,
            'password' => $request->password,
        ]);

        if ($response->ok()) {
            $responseData = $response->json();
            $accessToken = $responseData['data']['access_token'] ?? null;

            if ($accessToken) {
                // Lakukan GET request ke API profil dengan access_token
                $profileResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'accept' => 'application/json',
                ])->get('https://api.dinus.ac.id/api/v1/siadin/profile');

                if ($profileResponse->ok()) {
                    $profileData = $profileResponse->json();
                    $fullName = $profileData['data']['nama'];

                    // Cari user berdasarkan NIM
                    $user = User::where('nim', $request->nim)->first();

                    // Jika user tidak ada, buat user baru
                    if (!$user) {
                        $user = User::create([
                            'nim' => $request->nim,
                            'name' => $fullName,
                            'password' => Hash::make(Str::random(16)),
                            'role' => 'visitor',
                        ]);
                    } else {
                        // Update nama jika user ditemukan dengan nama 'Not Registered'
                        if ($user->name === 'Not Registered') {
                            $user->update(['name' => $fullName]);
                        }
                    }

                    Auth::login($user);
                    return redirect('/dashboard');
                } else {
                    return back()->withErrors(['loginError' => 'Failed to fetch profile data']);
                }
            } else {
                return back()->withErrors(['loginError' => 'Failed to obtain access token']);
            }
        } else {
            return back()->withErrors(['loginError' => 'Invalid credentials']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.showLogin')->with('success', 'Logged out successfully');
    }
}