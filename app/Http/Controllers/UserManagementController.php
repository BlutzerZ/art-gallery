<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.userManagement.index', compact('users'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'role' => 'required|string',
        ]);

        $user = User::find($request->id);

        if ($user) {
            $user->role = $request->role;
            $user->save();

            return redirect()->route('userManagement.index')->with('success', 'Role updated successfully');
        }

        return redirect()->route('userManagement.index')->with('error', 'User not found');
    }
}