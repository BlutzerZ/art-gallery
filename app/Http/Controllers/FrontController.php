<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $imageNews = Image::latest()->take(6)->get();
        $images = Image::all();

        $likesCount = Favorite::select('image_id', DB::raw('count(*) as count'))
        ->groupBy('image_id')
        ->pluck('count', 'image_id');

        $likedImageIds = Auth::check()
        ? Favorite::where('user_id', Auth::id())->pluck('image_id')->toArray()
            : [];

        return view('front.index', [
            'title' => 'Homepage Art Gallery Udinus',
            'imageNews' => $imageNews,
            'images' => $images,
            'likesCount' => $likesCount,
            'likedImageIds' => $likedImageIds
        ]);
    }

    public function show(string $id)
    {
        $likesCount = Favorite::select('image_id', DB::raw('count(*) as count'))
        ->groupBy('image_id')
        ->pluck('count', 'image_id');

        $likedImageIds = Auth::check()
        ? Favorite::where('user_id', Auth::id())->pluck('image_id')->toArray()
            : [];

        $image = Image::find($id);

        return view('front.show', [
            'title' => 'Detail Art',
            'image' => $image,
            'likesCount' => $likesCount,
            'likedImageIds' => $likedImageIds
        ]);
    }
}
