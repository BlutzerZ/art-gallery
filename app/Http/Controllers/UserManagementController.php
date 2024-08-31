<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserManagementController extends Controller
{
    public function show()
    {
        $users = User::all();
        return view('dashboard.userManagement.show', compact('users'), [
            'title' => 'User Management'
        ]);
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

            return redirect()->route('userManagement.show')->with('success', 'Role updated successfully');
        }

        return redirect()->route('userManagement.show')->with('error', 'User not found');
    }
}