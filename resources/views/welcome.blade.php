<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }} | Sign In</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen text-slate-100" style="font-family: 'Space Grotesk', sans-serif;">
    <main class="relative min-h-screen overflow-hidden bg-slate-950">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(8,145,178,0.35),transparent_40%),radial-gradient(circle_at_80%_10%,rgba(37,99,235,0.35),transparent_35%),radial-gradient(circle_at_70%_80%,rgba(14,116,144,0.25),transparent_35%)]"></div>
        <div class="absolute inset-0 opacity-20 [background-image:linear-gradient(rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.08)_1px,transparent_1px)] [background-size:32px_32px]"></div>

        <div class="relative z-10 flex min-h-screen items-center justify-center px-6 py-12">
            <div class="w-full max-w-md rounded-3xl border border-white/15 bg-white/10 p-8 shadow-[0_30px_100px_rgba(8,145,178,0.25)] backdrop-blur-xl">
                <div class="mb-8 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-600 shadow-lg shadow-cyan-500/40">
                        <i class="ri-task-line text-3xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold tracking-tight text-white">TaskFlow</h1>
                    <p class="mt-2 text-sm text-slate-200">Secure workspace access</p>
                </div>

                <x-auth-session-status class="mb-4 text-sm text-emerald-300" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-200">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full rounded-xl border border-white/20 bg-slate-900/70 px-4 py-3 text-white placeholder:text-slate-400 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/40"
                            placeholder="you@company.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-200">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full rounded-xl border border-white/20 bg-slate-900/70 px-4 py-3 text-white placeholder:text-slate-400 focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/40"
                            placeholder="Enter your password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-200">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-white/30 bg-slate-900/60 text-cyan-500 focus:ring-cyan-400/60">
                            Remember me
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-cyan-300 hover:text-cyan-200">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="mt-2 w-full rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-3 text-base font-semibold text-white transition hover:scale-[1.01] hover:from-cyan-400 hover:to-blue-500">
                        Log In
                    </button>
                </form>

                <p class="mt-6 text-center text-xs text-slate-300">
                    Need an account? Contact your administrator.
                </p>
            </div>
        </div>
    </main>
</body>
</html>
