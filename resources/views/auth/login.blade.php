@extends('layouts.index')
@section('content')
    <section class="flex flex-col min-h-screen bg-primary lg:flex-row">
        <!-- Bagian kiri: Gambar -->
        <div class="items-center justify-center hidden lg:flex lg:flex-col lg:w-1/2">
            <img src="/assets/img/udinus.png" alt="Descriptive Image" class="max-w-xs">
            <h6 class="mt-12 text-4xl font-bold text-center font-dancingScript text-light">Udinus Art Showcase</h6>
        </div>

        <!-- Bagian kanan: Form -->
        <div
            class="w-full lg:max-w-2xl lg:w-1/2 min-h-screen flex flex-col items-center justify-center py-[46px] px-4 gap-8">
            <form method="POST" action="{{ route('auth.login') }}"
                class="flex flex-col w-full md:w-2/3 bg-white p-[24px_16px] gap-8 rounded-[22px] items-center md:py-[52px] lg:px-10">
                @csrf
                <img src="/assets/img/udinus.png" alt="Udinus" class="w-1/6 mx-auto md:w-1/5 lg:hidden">
                <div class="flex flex-col gap-1 text-center mt-[-22px] md:mt-0">
                    <h1 class="font-semibold text-2xl md:text-3xl leading-[42px]">Sign In</h1>
                    <p class="text-sm leading-[25px] tracking-[0.6px] text-darkGrey md:mt-3 md:text-base">Welcome Back!
                        Enter your valid data</p>
                </div>
                @if ($errors->has('loginError'))
                    <div
                        class="bg-red-500 p-[14px_24px] w-full max-w-[311px] md:max-w-[411px] rounded-[10px] text-center text-white font-semibold transition-all duration-300">
                        {{ $errors->first('loginError') }}
                    </div>
                @endif
                <div class="flex flex-col gap-[15px] w-full max-w-[311px] md:max-w-[411px]">
                    <div class="flex flex-col w-full gap-1">
                        <p class="font-semibold md:text-base">NIM</p>
                        <div
                            class="flex items-center gap-3 p-[16px_12px] border border-light rounded-xl focus-within:border-primary transition-all duration-300">
                            <div class="flex w-4 h-4 shrink-0">
                                <img src="assets/icons/sms.svg" alt="icon">
                            </div>
                            <input type="text" id="nim" name="nim"
                                class="appearance-none outline-none w-full text-sm placeholder:text-[#BFBFBF] tracking-[0.35px]"
                                placeholder="A11.2000.12345" value="{{ old('nim') }}">
                        </div>
                    </div>
                    <div class="flex flex-col w-full gap-1">
                        <p class="font-semibold md:text-base">Password</p>
                        <div
                            class="flex items-center gap-3 p-[16px_12px] border border-[#BFBFBF] rounded-xl focus-within:border-primary transition-all duration-300">
                            <div class="flex w-4 h-4 shrink-0">
                                <img src="assets/icons/password-lock.svg" alt="icon">
                            </div>
                            <input type="password" id="password" name="password"
                                class="appearance-none outline-none w-full text-sm placeholder:text-[#BFBFBF] tracking-[0.35px]"
                                placeholder="*****">
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="bg-primary p-[16px_24px] w-full max-w-[311px] md:max-w-[411px] rounded-[10px] text-center text-white font-semibold transition-all duration-300 hover:bg-warning hover:text-primary">Sign
                    In</button>

                <p class="text-sm text-center tracking-035 text-darkGrey"><a href="/dashboard"
                        class="text-blue-500 font-semibold tracking-[0.6px]">Back to Home</a></p>
            </form>
        </div>
    </section>
@endsection
