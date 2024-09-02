<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManageParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'participant')->get();

        return view('dashboard.manageParticipants.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.manageParticipants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
        ]);

        if (User::where('nim', $request->nim)->exists()) {
            return redirect()
                ->route('manage-participants.create')
                ->withErrors(['nim' => 'NIM already exists']);
        } else {
            $user = [
                'nim' => $request->input('nim'),
                'name' => 'Blank',
                'password' => Hash::make(Str::random(16)),
                'role' => 'participant',
            ];

            User::create($user);

            return redirect()->route('manage-participants.index')->with('success', 'Participant added successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        return view('dashboard.manageParticipants.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nim' => 'required|string',
        ]);

        if (User::where('nim', $request->nim)->where('id', '!=', $id)->exists()) {
            return redirect()
                ->route('manage-participants.edit', $id)
                ->withErrors(['nim' => 'NIM already exists']);
        } else {
            $user = [
                'nim' => $request->input('nim'),
            ];

            User::where('id', $id)->update($user);

            return redirect()->route('manage-participants.index')->with('success', 'Participant updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);

        return redirect()->route('manage-participants.index')->with('success', 'Participant deleted successfully');
    }
}
