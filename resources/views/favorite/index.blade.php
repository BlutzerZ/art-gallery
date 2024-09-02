@extends('layouts.index')
@section('content')
    <section id="content" class="flex flex-col w-full min-h-screen gap-8 pb-4 mx-auto bg-youngPrimary">
        <nav class="flex items-center justify-between w-full px-4 mt-8">
            <a href="{{ route('front') }}">
                <img src="assets/icons/back.png" alt="back">
            </a>
            <p class="m-auto font-semibold text-center">My Favorite</p>
            <div class="w-12"></div>
        </nav>
        <div class="flex flex-col gap-3 px-4">
            @foreach ($images as $image)
                <a href="{{ route('show', ['id' => $image->id]) }}" class="card">
                    <div class="bg-white p-4 rounded-[26px] flex flex-col gap-3">
                        <div class="flex items-center gap-4">
                            <div class="w-[92px] h-[92px] flex shrink-0 rounded-xl overflow-hidden">
                                <img src="{{ $image->url_image }}" class="object-cover object-center w-full h-full"
                                    alt="thumbnail">
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="font-semibold">{{ $image->title }}</p>
                                <div class="flex items-center gap-1">
                                    <span
                                        class="text-sm text-darkGrey tracking-035">{{ substr($image->description, 0, 50) }}...</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-1">
                            <p class="text-xs text-left">By {{ ucwords(strtolower($image->user->name)) }}</p>
                            <div class="flex items-center gap-1">
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
                </a>
            @endforeach
        </div>
    </section>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/js/two-lines-text.js') }}"></script>
@endpush
