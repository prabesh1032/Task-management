<!-- resources/views/welcome.blade.php -->

@extends('layouts.master')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-indigo-900 to-purple-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <div class="container mx-auto px-6 py-24 md:py-32 flex flex-col items-center text-center relative z-10">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-blue-500">
                        Work Smarter, Not Harder
                    </span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-10 max-w-2xl mx-auto">
                    The ultimate task management platform that helps you organize, prioritize, and collaborate with ease.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg shadow-cyan-500/20">
                        Get Started Free
                    </a>
                    <a href="#features" class="px-8 py-4 border border-white/20 hover:border-white/40 text-white font-semibold rounded-lg transition-all duration-300 hover:bg-white/10">
                        Explore Features
                    </a>
                </div>
            </div>

            <div class="mt-20 w-full max-w-5xl mx-auto relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl opacity-20 blur-lg"></div>
                <div class="relative bg-gray-900/80 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                         alt="Dashboard preview"
                         class="w-full h-auto opacity-90">
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-20">
                <span class="inline-block px-4 py-2 bg-cyan-100 text-cyan-800 rounded-full text-sm font-semibold mb-4">
                    Powerful Features
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Everything You Need to Stay Productive
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Our platform combines powerful tools with intuitive design to help you accomplish more.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-cyan-100">
                    <div class="w-14 h-14 bg-cyan-50 rounded-lg flex items-center justify-center mb-6 text-cyan-600">
                        <i class="ri-task-line ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Smart Task Management</h3>
                    <p class="text-gray-600">
                        Create, organize, and prioritize tasks with our intuitive drag-and-drop interface.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-purple-100">
                    <div class="w-14 h-14 bg-purple-50 rounded-lg flex items-center justify-center mb-6 text-purple-600">
                        <i class="ri-team-line ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Team Collaboration</h3>
                    <p class="text-gray-600">
                        Assign tasks, share files, and communicate seamlessly with your team members.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-blue-100">
                    <div class="w-14 h-14 bg-blue-50 rounded-lg flex items-center justify-center mb-6 text-blue-600">
                        <i class="ri-bar-chart-line ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Progress Tracking</h3>
                    <p class="text-gray-600">
                        Visualize your progress with interactive charts and detailed analytics.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-green-100">
                    <div class="w-14 h-14 bg-green-50 rounded-lg flex items-center justify-center mb-6 text-green-600">
                        <i class="ri-calendar-todo-line ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Deadline Management</h3>
                    <p class="text-gray-600">
                        Never miss a deadline with smart reminders and calendar integration.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-orange-100">
                    <div class="w-14 h-14 bg-orange-50 rounded-lg flex items-center justify-center mb-6 text-orange-600">
                        <i class="ri-lightbulb-flash-line ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Smart Suggestions</h3>
                    <p class="text-gray-600">
                        AI-powered recommendations to optimize your workflow and productivity.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 hover:border-red-100">
                    <div class="w-14 h-14 bg-red-50 rounded-lg flex items-center justify-center mb-6 text-red-600">
                        <i class="ri-shield-check-line ri-2x"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Enterprise Security</h3>
                    <p class="text-gray-600">
                        Your data is protected with bank-level encryption and regular backups.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Productivity Stats -->
    <section class="py-20 bg-gradient-to-r from-indigo-700 to-purple-800 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-12">Trusted by Teams Worldwide</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">10K+</div>
                    <div class="text-gray-300">Active Users</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">95%</div>
                    <div class="text-gray-300">Productivity Increase</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">500+</div>
                    <div class="text-gray-300">Teams</div>
                </div>
                <div class="p-6">
                    <div class="text-4xl font-bold mb-2">24/7</div>
                    <div class="text-gray-300">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold mb-4">
                    What Our Users Say
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Loved by Teams Everywhere
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Don't just take our word for it. Here's what our users have to say.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold mr-4">
                            JD
                        </div>
                        <div>
                            <h4 class="font-bold">John Doe</h4>
                            <p class="text-gray-500 text-sm">Product Manager</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "This platform transformed how our team works. We've seen a 40% increase in productivity since switching."
                    </p>
                    <div class="flex text-yellow-400">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold mr-4">
                            AS
                        </div>
                        <div>
                            <h4 class="font-bold">Alice Smith</h4>
                            <p class="text-gray-500 text-sm">Marketing Director</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "The collaboration features are incredible. Our remote team has never been more aligned on projects."
                    </p>
                    <div class="flex text-yellow-400">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-half-fill"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gray-50 p-8 rounded-xl border border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full bg-cyan-500 flex items-center justify-center text-white font-bold mr-4">
                            RJ
                        </div>
                        <div>
                            <h4 class="font-bold">Robert Johnson</h4>
                            <p class="text-gray-500 text-sm">CTO</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "The security features give me peace of mind, while the interface keeps my team happy and productive."
                    </p>
                    <div class="flex text-yellow-400">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    Ready to Transform Your Productivity?
                </h2>
                <p class="text-xl text-gray-300 mb-10">
                    Join thousands of teams who are already working smarter with our platform.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg shadow-cyan-500/20">
                        Start Free Trial
                    </a>
                    <a href="#" class="px-8 py-4 border border-white/20 hover:border-white/40 text-white font-semibold rounded-lg transition-all duration-300 hover:bg-white/10">
                        Schedule Demo
                    </a>
                </div>
                <p class="mt-6 text-gray-400 text-sm">
                    No credit card required. 14-day free trial.
                </p>
            </div>
        </div>
    </section>
@endsection
