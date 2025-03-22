<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project History Check</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'dark-primary': '#1a1b1e',
                        'dark-secondary': '#25262b',
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

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(31, 41, 55, 0.5);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(107, 114, 128);
        }

        /* Gradient Animation */
        .animate-gradient {
            background: linear-gradient(
                270deg,
                #3b82f6,
                #8b5cf6,
                #3b82f6
            );
            background-size: 200% 200%;
            animation: gradient 8s linear infinite;
        }

        .glass-effect {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-dark-primary text-gray-100 min-h-screen">
    <!-- Background Elements -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-1/2 -right-1/2 w-full h-full bg-blue-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-1/2 -left-1/2 w-full h-full bg-purple-500/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-dark-secondary/80 border-b border-gray-700/50 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg blur transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                            <div class="relative bg-dark-secondary border border-gray-700/50 p-2 rounded-lg">
                                <i class="ri-folder-line text-2xl bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent"></i>
                            </div>
                        </div>
                        <span class="font-semibold text-lg bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">
                            Project History
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-8rem)] relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <!-- <footer class="bg-dark-secondary/80 border-t border-gray-700/50 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-dark-secondary border border-gray-700/50 rounded-lg flex items-center justify-center">
                        <i class="ri-code-line text-blue-500"></i>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-400">
                        © {{ date('Y') }} All rights reserved
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        Built with <i class="ri-heart-fill text-red-500"></i> by Your Company
                    </p>
                </div>
            </div>
        </div>
    </footer> -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Optional: Add page transition -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('opacity-0');
            setTimeout(() => {
                document.body.classList.remove('opacity-0');
                document.body.classList.add('transition-opacity', 'duration-500', 'opacity-100');
            }, 0);
        });
    </script>
</body>
</html> 