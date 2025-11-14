@extends('layouts.master')

@section('content')
    <!-- Hero Section with Login Form -->
    <section class="relative bg-gradient-to-br from-indigo-900 to-purple-800 text-white overflow-hidden" id="hero">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <div class="container mx-auto px-6 py-24 md:py-32 flex flex-col md:flex-row items-center gap-12 relative z-10">
            <!-- Left Column - Hero Text -->
            <div class="md:w-1/2">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">
                        Work Smarter, Not Harder
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10">
                    The ultimate task management platform that helps you organize, prioritize, and collaborate with ease.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Public registration disabled: prompt to contact admin -->
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg shadow-cyan-500/20">
                        Sign In
                    </a>
                </div>
            </div>

            <!-- Right Column - Login Form -->
            <div class="md:w-1/2 bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 shadow-xl">
                <h2 class="text-2xl font-bold mb-6 text-center">Sign In to Your Account</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-white/80 mb-2">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-white/80 mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded bg-white/10 border-white/20 text-cyan-500 focus:ring-cyan-500" name="remember">
                            <span class="ms-2 text-sm text-white/80">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-cyan-300 hover:text-cyan-200 underline">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="w-full py-3 px-4 bg-cyan-600 hover:bg-cyan-700 text-white font-semibold rounded-lg transition duration-200">
                        {{ __('Log in') }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-white/80">
                        If you don't have an account, please contact your administrator to be added.
                    </p>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent"></div>
    </section>

<section class="py-20 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
        <p class="text-lg text-gray-300 mb-8">Join thousands of users in managing tasks and achieving goals efficiently.</p>
        <a href="#hero" class="px-8 py-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105">
            Create an Account
        </a>
    </div>
</section>

@endsection
