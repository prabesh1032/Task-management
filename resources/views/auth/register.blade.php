@extends('layouts.master')

@section('content')
    <!-- Hero Section with Register Form -->
    <section class="relative bg-gradient-to-br from-indigo-900 to-purple-800 text-white overflow-hidden min-h-screen">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <div class="container mx-auto px-6 py-12 flex flex-col md:flex-row items-center gap-8 relative z-10">
            <!-- Left Column - Hero Text -->
            <div class="md:w-1/2 lg:pr-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">
                        Work Smarter, Not Harder
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 mb-8">
                    The ultimate task management platform that helps you organize, prioritize, and collaborate with ease.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('home') }}"
                       class="flex items-center justify-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-medium rounded-lg transition-all duration-300 border border-white/20 hover:shadow-lg">
                        <i class="ri-arrow-left-line mr-2"></i> Back to Login
                    </a>
                </div>
            </div>

            <!-- Right Column - Register Form -->
            <div class="md:w-1/2 mt-8 md:mt-0">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 md:p-8 border border-white/20 shadow-xl">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 rounded-full bg-white/10 flex items-center justify-center border-2 border-white/20">
                            <i class="ri-user-add-line text-white text-2xl"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold mb-6 text-center">Create Your Account</h2>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-white/80 mb-2">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-user-line text-gray-400"></i>
                                </div>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                    class="w-full pl-10 pr-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                    placeholder="John Doe">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-white/80 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-mail-line text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                    placeholder="you@example.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-white/80 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-lock-line text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-white/80 mb-2">Confirm Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="ri-lock-line text-gray-400"></i>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="w-full pl-10 pr-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Profile Picture -->
                        <div>
                            <label class="block text-sm font-medium text-white/80 mb-3">Profile Photo</label>
                            <div class="flex items-center space-x-4">
                                <div class="shrink-0">
                                    <img id="profile_preview" class="h-16 w-16 rounded-full object-cover border-2 border-white/20"
                                         src="{{ asset('useravatar.avif') }}" alt="Preview">
                                </div>
                                <label class="block w-full">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file" name="profile_picture" required accept="image/*"
                                        class="block w-full text-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-white/10 file:text-white hover:file:bg-white/20 focus:outline-none"
                                        onchange="document.getElementById('profile_preview').src = window.URL.createObjectURL(this.files[0])">
                                </label>
                            </div>
                            @error('profile_picture')
                                <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full flex items-center justify-center py-3 px-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-medium rounded-lg transition duration-200 shadow-lg mt-6">
                            <i class="ri-user-add-line mr-2"></i> Create Account
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-white/80">
                            Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-cyan-300 hover:text-cyan-200 transition-colors">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Why Choose Us?</h2>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                    Our platform provides you with all the tools to streamline your workflow and achieve your goals effortlessly.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="w-12 h-12 bg-cyan-50 rounded-lg flex items-center justify-center mb-4 text-cyan-600">
                        <i class="ri-layout-masonry-line text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Intuitive Interface</h3>
                    <p class="text-gray-600">Easily navigate through a user-friendly and intuitive platform.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mb-4 text-purple-600">
                        <i class="ri-team-line text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Team Collaboration</h3>
                    <p class="text-gray-600">Work seamlessly with your team members in real-time.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-4 text-blue-600">
                        <i class="ri-bar-chart-line text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Advanced Analytics</h3>
                    <p class="text-gray-600">Get insights into your productivity with detailed reports.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
            <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
                Join thousands of professionals who are already boosting their productivity with our platform.
            </p>
            <a href="#hero" class="inline-flex items-center px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-lg shadow-lg transition duration-200">
                <i class="ri-user-add-line mr-2"></i> Create Your Account Now
            </a>
        </div>
    </section>

    <script>
        // Live preview for profile picture
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile_preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
