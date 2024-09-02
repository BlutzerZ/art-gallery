<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function index()
    {
        $likedImageIds = Auth::check()
            ? Favorite::where('user_id', Auth::id())->pluck('image_id')
            : collect();

        $likesCount = Favorite::select('image_id', DB::raw('count(*) as count'))
        ->groupBy('image_id')
        ->pluck('count', 'image_id');

        $likedImageIds = Auth::check()
        ? Favorite::where('user_id', Auth::id())->pluck('image_id')->toArray()
            : [];

        $images = Image::whereIn('id', $likedImageIds)->get();

        return view('favorite.index', [
            'title' => 'My Favorite',
            'images' => $images,
            'likesCount' => $likesCount,
            'likedImageIds' => $likedImageIds
        ]);
    }

    public function store(Request $request)
    {
        $userId = $request->input('user_id');
        $imageId = $request->input('image_id');

        $existingLike = Favorite::where('user_id', $userId)->where('image_id', $imageId)->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Favorite::create([
                'user_id' => $userId,
                'image_id' => $imageId
            ]);
        }

        // Redirect kembali dengan informasi yang dibutuhkan
        return redirect()->back();
    }
}