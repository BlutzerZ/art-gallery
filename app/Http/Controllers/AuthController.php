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
            return redirect('/');
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
                $accessToken = $response['data']['access_token'];
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get('https://api.dinus.ac.id/api/v1/siadin/profile');
                $responseData = $response->json();
                $name = $responseData['data']['nama'];
                
                $user = User::create([
                    'nim' => $request->username,
                    'name' => $name,
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'visitor',
                ]);
            }

            if ($user->name == "Blank") {
                $accessToken = $response['data']['access_token'];
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get('https://api.dinus.ac.id/api/v1/siadin/profile');
                $responseData = $response->json();
                $name = $responseData['data']['nama'];
                
                $user->name = $name;
                $user->save();
            }

            Auth::login($user);

            return redirect('/')->with('success', 'Logged in successfully');
    
        } else {
            return back()->withErrors(['loginError' => 'Invalid cre 1dentials']);
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