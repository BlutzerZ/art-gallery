<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Image;

class GalleryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $images = Image::where('user_id', $userId)->get();
        
        return view('dashboard.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('dashboard.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $path = $request->file('image')->store('images', 'public');

        $image = new Image([
            'user_id' => Auth::id(),
            'url_image' => Storage::url($path),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        $image->save();

        return redirect()->route('gallery.index')->with('success', 'Image added successfully');
    }

    public function show($id)
    {
        $userId = Auth::id();
        $image = Image::where('user_id', $userId)->where('id', $id)->firstOrFail();
        
        return view('dashboard.gallery.show', compact('image'));
    }

    public function edit($id)
    {
        $userId = Auth::id();
        $image = Image::where('user_id', $userId)->where('id', $id)->firstOrFail();
        
        return view('dashboard.gallery.edit', compact('image'));
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $image = Image::where('user_id', $userId)->where('id', $id)->firstOrFail();

        $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($image->url_image) {
                $oldPath = str_replace('/storage/', '', $image->url_image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('images', 'public');
            $image->url_image = Storage::url($path);
        }

        $image->title = $request->input('title');
        $image->description = $request->input('description');
        $image->save();

        return redirect()->route('gallery.index')->with('success', 'Image updated successfully');
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $image = Image::where('user_id', $userId)->where('id', $id)->firstOrFail();

        $image->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully');
    }
}