<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - ChasoulUIX Project</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets (TailwindCSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dark-secondary">
    <div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-dark-primary rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300 border border-gray-700">
            <!-- Logo dan Header -->
            <div class="text-center p-6 bg-gradient-to-r from-gray-800 to-gray-900">
                <h1 class="text-3xl font-bold text-gray-100 mb-2 animate-fadeIn">Chasouluix Project</h1>
                <p class="text-gray-400">Login to access your account</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" class="p-8">
                @csrf
                
                <!-- Email Input -->
                <div class="mb-6 transform transition-all duration-300 hover:-translate-y-1">
                    <label for="email" class="block text-gray-300 text-sm font-semibold mb-2">Email Address</label>
                    <div class="relative">
                        <input id="email" type="email" name="email" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-gray-100
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors duration-300"
                            required autocomplete="email" autofocus
                            placeholder="your@email.com">
                        <span class="absolute right-3 top-3 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-6 transform transition-all duration-300 hover:-translate-y-1">
                    <label for="password" class="block text-gray-300 text-sm font-semibold mb-2">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password"
                            class="w-full px-4 py-3 rounded-lg bg-gray-800 border border-gray-700 text-gray-100
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-colors duration-300"
                            required autocomplete="current-password"
                            placeholder="••••••••">
                        <span class="absolute right-3 top-3 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" 
                            class="rounded bg-gray-800 border-gray-700 text-blue-500 focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-sm text-gray-400">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                            class="text-sm text-blue-400 hover:text-blue-300 transition-colors duration-300">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg px-4 py-3 font-semibold
                    transform transition-all duration-300 hover:scale-105 hover:shadow-lg hover:from-blue-500 hover:to-blue-600
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</body>
</html>