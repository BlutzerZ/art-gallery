@extends('layouts.index')
@section('content')
    <section id="content" class="flex flex-col w-full min-h-screen gap-8 pb-5 mx-auto bg-youngPrimary">
        <nav class="relative flex items-center w-full px-4 mt-8">
            <a href="{{ route('front') }}" class="absolute pl-1">
                <img src="{{ asset('assets/icons/back.png') }}" alt="back">
            </a>
            <p class="flex-1 font-semibold text-center">Detail Image</p>
        </nav>
        <div class="lg:grid lg:grid-cols-2">
            <div id="image-details" class="flex flex-col gap-3 px-4">
                <div class="w-full h-[345px] flex shrink-0 rounded-xl overflow-hidden">
                    <img id="image-thumbnail" src={{ $image->url_image }} class="object-cover object-center w-full h-full"
                        alt="thumbnail">
                </div>
            </div>
            <div class="mx-4 flex mt-4 lg:mt-0 flex-col gap-3 bg-white p-[16px_24px] rounded-[22px]">
                <h2 class="font-semibold">{{ $image->title }}</h2>
                <p id="readMore" class="text-sm leading-[22px] tracking-035 text-darkGrey">
                    {{ $image->description }}
                </p>
                <div class="flex flex-col gap-1 text-right">
                    <div class="flex items-center justify-end gap-1">
                        <form action="{{ route('gallery.favorite') }}" method="post">
                            @csrf
                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <button type="submit" class="focus:outline-none">
                                <i
                                    class="{{ in_array($image->id, $likedImageIds) ? 'fa-solid fa-heart' : 'fa-regular fa-heart' }}"></i>
                            </button>
                        </form> |
                        <span class="font-semibold text-sm leading-[21px]">
                            {{ $likesCount[$image->id] ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
