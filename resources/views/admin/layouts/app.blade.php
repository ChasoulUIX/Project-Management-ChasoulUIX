<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - ChasoulUIX')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Vite Assets (TailwindCSS & JS) -->
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-dark-primary text-gray-100 font-sans" 
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }" 
      @resize.window="sidebarOpen = window.innerWidth >= 1024">
    <div class="flex min-h-screen">
        <!-- Overlay untuk mobile -->
        <div x-show="sidebarOpen && window.innerWidth < 1024" 
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 lg:hidden z-20">
        </div>

        <!-- Sidebar -->
        <div x-cloak
             :class="{'translate-x-0': sidebarOpen, '-translate-x-full lg:translate-x-0': !sidebarOpen}"
             class="w-72 fixed h-screen bg-dark-secondary border-r border-gray-700/50 overflow-y-auto sidebar-scroll z-30 transform transition-transform duration-300 ease-in-out">
            <!-- Logo Area -->
            <div class="flex items-center justify-between gap-2 px-6 h-16 border-b border-gray-700/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-tr from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                        <i class="ri-admin-line text-xl text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 text-transparent bg-clip-text">
                        AdminPanel
                    </span>
                </div>
                <!-- Tombol close untuk mobile -->
                <button @click="sidebarOpen = false" class="lg:hidden p-2 hover:bg-gray-800/50 rounded-lg">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Navigation -->
            <div class="sidebar-menu p-4">
                <nav class="space-y-6">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                        <i class="menu-icon ri-dashboard-line text-xl"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>

                    <!-- Clients Section -->
                    <div class="space-y-2">
                        <p class="section-title text-xs font-semibold text-gray-400 uppercase mb-2">
                            CLIENTS
                        </p>
                        
                        <a href="{{ route('admin.clients.index') }}" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-user-star-line text-xl"></i>
                            <span class="menu-text">Clients</span>
                        </a>

                        <!-- <a href="{{ route('admin.clients.create') }}" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-user-add-line text-xl"></i>
                            <span class="menu-text">Add Client</span>
                        </a> -->
                    </div>

                    <!-- Projects Section -->
                    <div class="space-y-2">
                        <p class="section-title text-xs font-semibold text-gray-400 uppercase mb-2">
                            PROJECTS
                        </p>
                        
                        <a href="{{ route('admin.projects.index') }}" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-folder-line text-xl"></i>
                            <span class="menu-text">Projects</span>
                        </a>

                        <a href="{{ route('admin.projects.create') }}" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-add-circle-line text-xl"></i>
                            <span class="menu-text">Add Project</span>
                        </a>
                    </div>

                    <!-- Team Section -->
                    <div class="space-y-2">
                        <p class="section-title text-xs font-semibold text-gray-400 uppercase mb-2">
                            TEAM
                        </p>
                        
                        <a href="{{ route('admin.teams.index') }}" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-team-line text-xl"></i>
                            <span class="menu-text">Team Members</span>
                        </a>

                        <a href="{{ route('admin.teams.create') }}" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-user-add-line text-xl"></i>
                            <span class="menu-text">Add Member</span>
                        </a>
                    </div>

                    <!-- Finance Section -->
                    <div class="space-y-2">
                        <p class="section-title text-xs font-semibold text-gray-400 uppercase mb-2">
                            FINANCE
                        </p>
                        
                        <a href="{{ route('admin.profit-deductions.index') }}" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-subtract-line text-xl"></i>
                            <span class="menu-text">Profit Deductions</span>
                        </a>

                        <a href="{{ route('admin.projects.index') }}?filter=payments" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-money-dollar-circle-line text-xl"></i>
                            <span class="menu-text">Project Payments</span>
                        </a>

                        <a href="{{ route('admin.teams.index') }}?filter=unpaid" 
                           class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300">
                            <i class="menu-icon ri-wallet-line text-xl"></i>
                            <span class="menu-text">Team Payments</span>
                        </a>
                    </div>

                    <!-- Settings Section -->
                    <div class="space-y-2">
                      

                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="menu-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-red-500">
                                <i class="menu-icon ri-logout-box-line text-xl"></i>
                                <span class="menu-text">Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div :class="{'lg:ml-72': sidebarOpen}"
             class="w-full flex-1 transition-all duration-300 ease-in-out">
            <!-- Top Navigation -->
            <div class="h-20 flex items-center justify-between px-8 bg-dark-secondary/50 backdrop-blur-xl border-b border-gray-700/50 sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="p-2 hover:bg-gray-800/50 rounded-lg transition-colors lg:hidden">
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
                            <p class="text-sm font-medium">ChasoulUIX</p>
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

        /* Custom Scrollbar untuk Sidebar */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: #4B5563 transparent;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #4B5563;
            border-radius: 2px;
        }

        @media (max-width: 1024px) {
            .sidebar-scroll {
                will-change: transform;
            }
        }

        .transform {
            will-change: transform;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentRoute = '{{ request()->route()->getName() }}';
            
            // Find and add active class to current menu item
            document.querySelectorAll('.menu-item').forEach(item => {
                const href = item.getAttribute('href');
                if (href && href.includes(currentRoute)) {
                    item.classList.add('active');
                }
            });

            // Prevent transition on page load
            window.addEventListener('load', function() {
                document.body.classList.add('ready');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>

