@extends('layouts.index')
@section('content')
    <section id="content" class="flex flex-col w-full min-h-screen gap-8 pb-10 mx-auto bg-youngPrimary">
        <nav class="flex items-center justify-between w-full px-4 mt-8">
            <div class="relative flex items-center gap-3">
                <input type="checkbox" id="dropdownToggle" class="hidden peer" />

                <label for="dropdownToggle"
                    class="cursor-pointer w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_20px_0_#00000008]">
                    <img src="{{ asset('assets/img/udinus.png') }}" class="object-cover object-center w-full h-full"
                        alt="photo">
                </label>

                <div class="flex flex-col gap-1">
                    <p class="text-xs tracking-035">Welcome!</p>
                    <p class="font-semibold">Hello, Guest!</p>
                </div>

                <!-- Dropdown menu -->
                <div id="dropdownInformation"
                    class="absolute left-0 z-10 hidden mt-2 divide-y rounded-lg shadow divide-light bg-primary top-full w-44 peer-checked:block">
                    <div class="px-4 py-3 text-sm text-light">
                        <div class="font-medium truncate">A11.2022.12654</div>
                    </div>
                    <ul class="py-2 text-sm text-light">
                        @organizer
                        <li>
                            <a href="{{ route('userManagement.index') }}"
                                class="block px-4 py-2 hover:bg-warning text-light hover:text-primary">Dashboard</a>
                        </li>
                        @endorganizer
                        @participant
                        <li>
                            <a href="{{ route('gallery.index') }}" class="block px-4 py-2 hover:bg-warning text-light hover:text-primary">My
                                Art</a>
                        </li>
                        @endparticipant
                        <li>
                            <a href="{{ route('favorite') }}" class="block px-4 py-2 hover:bg-warning text-light hover:text-primary">My
                                Favorite</a>
                        </li>
                    </ul>
                    <div class="py-2">
                        <a href="#"
                            class="block px-4 py-2 text-sm hover:bg-warning text-light hover:text-primary">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <h1 class="font-semibold text-2xl leading-[36px] text-center">Explore the Beauty <br> of Art and Imagination</h1>
        <div id="recommendations" class="flex flex-col gap-3">
            <h2 class="px-4 font-semibold md:text-lg">Latest Work</h2>
            <div class="main-carousel card-container">
                @foreach ($imageNews as $imageNew)
                    <div class="px-2 group first-of-type:pl-4 last-of-type:pr-4">
                        <div
                            class="w-[288px] p-4 flex flex-col gap-3 rounded-[26px] bg-white shadow-[6px_8px_20px_0_#00000008]">
                            <a href="{{ route('show', ['id' => $imageNew->id]) }}">
                                <div class="w-full h-[330px] rounded-xl flex shrink-0 overflow-hidden">
                                    <img src="{{ $imageNew->url_image }}" class="object-cover w-full h-full"
                                        alt="thumbnails">
                                </div>
                            </a>
                            <div class="flex justify-between gap-2">
                                <div class="flex flex-col gap-1">
                                    <p class="font-semibold">{{ $imageNew->title }}</p>
                                    <div class="flex items-center gap-1">
                                        <span
                                            class="text-sm text-darkGrey tracking-035">{{ substr($imageNew->description, 0, 50) }}...</span>
                                    </div>
                                    <p class="text-xs">By {{ ucwords(strtolower($imageNew->user->name)) }}</p>
                                </div>
                                <div class="flex flex-col gap-1 text-right">
                                    </p>
                                    <div class="flex items-center justify-end gap-1">
                                        <form action="{{ route('gallery.favorite') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="image_id" value="{{ $imageNew->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                            <button type="submit" class="focus:outline-none">
                                                <i
                                                    class="{{ in_array($imageNew->id, $likedImageIds) ? 'fa-solid fa-heart' : 'fa-regular fa-heart' }}"></i>
                                            </button>
                                        </form>
                                        |
                                        <span class="font-semibold text-sm leading-[21px]">
                                            {{ $likesCount[$imageNew->id] ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="discover" class="px-4">
            <div class="w-full h-[130px] flex flex-col gap-[10px] rounded-[22px] items-center overflow-hidden relative">
                <div class="relative w-full h-full">
                    <img src="{{ asset('assets/img/art3.jpg') }}" class="object-cover object-center w-full h-full"
                        alt="background">
                    <div class="absolute inset-0 opacity-90 bg-gradient-to-t from-warning to-transparent"></div>
                </div>
                <div class="absolute z-10 flex flex-col gap-[10px] transform -translate-y-1/2 top-1/2 left-4">
                    <p class="font-semibold text-white md:text-lg">
                        Explore the Creative <br> Canvas of UDINUS
                    </p>
                </div>
            </div>
        </div>
        <div id="explore" class="px-4">
            <h2 class="font-semibold md:text-lg">More to Explore</h2>
            <div class="grid grid-cols-1 gap-4 mt-3 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($images as $image)
                    <div class="card md:w-full">
                        <div class="bg-white p-4 flex flex-col gap-3 rounded-[26px] shadow-[6px_8px_20px_0_#00000008]">
                            <a href="{{ route('show', ['id' => $image->id]) }}">
                                <div class="w-full h-full aspect-[311/150] rounded-xl overflow-hidden">
                                    <img src={{ $image->url_image }} class="object-cover object-center w-full h-full"
                                        alt="thumbnail">
                                </div>
                            </a>
                            <div class="flex justify-between gap-2">
                                <div class="flex flex-col gap-1">
                                    <p class="font-semibold">{{ $image->title }}</p>
                                    <div class="flex items-center gap-1">
                                        <span
                                            class="text-sm text-darkGrey tracking-035">{{ substr($image->description, 0, 50) }}...</span>
                                    </div>
                                    <p class="text-xs">By {{ ucfirst(strtolower($image->user->name)) }}</p>
                                </div>
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
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <footer class="bg-primary">
        <div class="w-full max-w-screen-xl p-4 mx-auto text-center">
            <span class="text-sm font-semibold text-center text-warning">© 2024 Art Gallery UDINUS. All Rights Reserved.
            </span>
        </div>
    </footer>
@endsection

@push('after-scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- JavaScript -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script src="{{ asset('assets/js/flickity-slider.js') }}"></script>
    <script src="{{ asset('assets/js/two-lines-text.js') }}"></script>
@endpush
