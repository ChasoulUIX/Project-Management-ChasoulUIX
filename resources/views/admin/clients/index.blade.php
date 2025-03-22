@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header dan Search -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <h2 class="text-2xl font-semibold">Clients</h2>
        
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <!-- Search Bar -->
            <form action="{{ route('admin.clients.index') }}" method="GET" 
                  class="w-full sm:w-80">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by name or WhatsApp..." 
                           class="w-full bg-dark-secondary border border-gray-700/50 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:border-blue-500/50 transition-colors text-gray-300"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ri-search-line text-gray-500"></i>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.clients.index') }}" 
                           class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-300">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </div>
            </form>

            <a href="{{ route('admin.clients.create') }}" 
               class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-center">
                <i class="ri-user-add-line mr-1"></i> Add Client
            </a>
        </div>
    </div>

    <!-- Client Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-user-line text-2xl text-blue-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Clients</p>
                    <h3 class="text-2xl font-bold">{{ $clients->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-folder-line text-2xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Projects</p>
                    <h3 class="text-2xl font-bold">{{ $totalProjects }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-2xl text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Value</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalValue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($clients as $client)
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $client->name }}</h3>
                        <a href="https://wa.me/{{ $client->formatted_whatsapp }}" 
                           target="_blank"
                           class="text-sm text-gray-400 hover:text-green-500 transition-colors inline-flex items-center gap-1">
                            <i class="ri-whatsapp-line"></i>
                            {{ $client->whatsapp }}
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.clients.edit', $client) }}" 
                           class="p-2 text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form action="{{ route('admin.clients.destroy', $client) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @if($client->address)
                <p class="text-sm text-gray-400 mb-4">
                    <i class="ri-map-pin-line mr-1"></i>
                    {{ $client->address }}
                </p>
                @endif

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-dark-primary rounded-lg p-3">
                        <p class="text-sm text-gray-400">Projects</p>
                        <p class="text-lg font-semibold">{{ $client->projects_count }}</p>
                    </div>
                    <div class="bg-dark-primary rounded-lg p-3">
                        <p class="text-sm text-gray-400">Total Value</p>
                        <p class="text-lg font-semibold">Rp {{ number_format($client->total_payments, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Recent Projects -->
                @if($client->projects->isNotEmpty())
                <div class="space-y-2 mb-4">
                    <p class="text-sm text-gray-400">Latest Project:</p>
                    @php
                        $latestProject = $client->projects()->latest()->first();  // Mengambil project terbaru
                    @endphp
                    <div class="bg-dark-primary rounded-lg p-3 flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium">{{ $latestProject->name }}</p>
                            <p class="text-xs text-gray-400">Rp {{ number_format($latestProject->price, 0, ',', '.') }}</p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs {{ 
                            match($latestProject->status) {
                                'success' => 'bg-green-500/10 text-green-500',
                                'pending' => 'bg-yellow-500/10 text-yellow-500',
                                'process' => 'bg-blue-500/10 text-blue-500',
                                'cancel' => 'bg-red-500/10 text-red-500',
                                default => 'bg-gray-500/10 text-gray-500'
                            }
                        }}">
                            {{ ucfirst($latestProject->status) }}
                        </span>
                    </div>
                </div>
                @endif

                <a href="{{ route('admin.clients.show', $client) }}" 
                   class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-400 transition-colors">
                    View Details
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $clients->links() }}
    </div>
</div>
@endsection 