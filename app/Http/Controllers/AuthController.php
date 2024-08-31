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
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $response = Http::post('https://api.dinus.ac.id/api/v1/siadin/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->ok()) {
            $user = User::where('nim', $request->username)->first();

            if (!$user) {
                $user = User::create([
                    'nim' => $request->username,
                    'name' => 'Blank',
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'visitor',
                ]);
            }

            Auth::login($user);

            return redirect('/dashboard');;
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