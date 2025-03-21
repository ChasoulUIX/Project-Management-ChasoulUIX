<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tambahkan Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        dark: {
                            'primary': '#0F172A',
                            'secondary': '#1E293B',
                            'accent': '#334155'
                        }
                    },
                    animation: {
                        'gradient': 'gradient 8s linear infinite',
                    },
                    keyframes: {
                        gradient: {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-primary text-gray-100 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-72 fixed h-screen bg-dark-secondary border-r border-gray-700/50 backdrop-blur-xl z-50">
            <!-- Logo Area -->
            <div class="flex items-center gap-2 px-8 h-20">
                <div class="w-8 h-8 bg-gradient-to-tr from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                    <i class="ri-admin-line text-xl text-white"></i>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 text-transparent bg-clip-text">
                    AdminPanel
                </span>
            </div>

            <!-- Navigation -->
            <nav class="mt-8 px-4">
                <div class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-800/50 rounded-xl transition-all duration-300 group">
                        <i class="ri-dashboard-line text-xl group-hover:text-blue-400"></i>
                        <span class="group-hover:text-blue-400">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.projects.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-gray-800/50 rounded-xl transition-all duration-300 group">
                        <i class="ri-folder-line text-xl group-hover:text-blue-400"></i>
                        <span class="group-hover:text-blue-400">Projects</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="ml-72 flex-1">
            <!-- Top Navigation -->
            <div class="h-20 flex items-center justify-between px-8 bg-dark-secondary/50 backdrop-blur-xl border-b border-gray-700/50">
                <div class="flex items-center gap-3">
                    <button class="p-2 hover:bg-gray-800/50 rounded-lg transition-colors">
                        <i class="ri-menu-line text-xl"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-100">Dashboard</h1>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <button class="p-2 hover:bg-gray-800/50 rounded-lg transition-colors relative">
                        <i class="ri-notification-line text-xl"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-blue-500 rounded-full"></span>
                    </button>

                    <!-- User Menu -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center">
                            <span class="text-lg font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">Administrator</p>
                        </div>
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="p-2 hover:bg-red-500/10 hover:text-red-500 rounded-lg transition-all duration-300">
                                <i class="ri-logout-box-line text-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </div>
    </div>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* Gradient Animation */
        .animate-gradient {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            background-size: 200% 200%;
            animation: gradient 8s linear infinite;
        }
    </style>
</body>
</html>
