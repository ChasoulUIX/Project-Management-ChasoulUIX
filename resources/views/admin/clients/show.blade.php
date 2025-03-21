@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.clients.index') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
            <i class="ri-arrow-left-line"></i>
            <span>Back to Clients</span>
        </a>
    </div>

    <!-- Client Header -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 flex justify-between items-start">
            <div class="space-y-1">
                <h2 class="text-2xl font-semibold text-white">{{ $client->name }}</h2>
                <a href="https://wa.me/{{ $client->formatted_whatsapp }}" 
                   target="_blank"
                   class="text-gray-400 hover:text-green-500 transition-colors inline-flex items-center gap-1">
                    <i class="ri-whatsapp-line"></i>
                    {{ $client->whatsapp }}
                </a>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.clients.edit', $client) }}" 
                   class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors inline-flex items-center gap-2">
                    <i class="ri-edit-line"></i>
                    Edit Client
                </a>
                <form action="{{ route('admin.clients.destroy', $client) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this client? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500/10 text-red-500 rounded-lg hover:bg-red-500/20 transition-colors inline-flex items-center gap-2">
                        <i class="ri-delete-bin-line"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Client Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-folder-line text-2xl text-blue-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Projects</p>
                    <h3 class="text-2xl font-bold">{{ $projects->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-2xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Value</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($projects->sum('price'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-time-line text-2xl text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Active Projects</p>
                    <h3 class="text-2xl font-bold">{{ $projects->where('status', '!=', 'completed')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Info & Projects -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Client Information -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
                <div class="p-6 border-b border-gray-700/50">
                    <h3 class="text-lg font-semibold">Client Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($client->address)
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Address</p>
                        <p class="text-gray-100 flex items-start gap-2">
                            <i class="ri-map-pin-line mt-1 text-gray-500"></i>
                            {{ $client->address }}
                        </p>
                    </div>
                    @endif
                    
                    @if($client->notes)
                    <div>
                        <p class="text-sm text-gray-400 mb-1">Notes</p>
                        <p class="text-gray-100 flex items-start gap-2">
                            <i class="ri-file-text-line mt-1 text-gray-500"></i>
                            {{ $client->notes }}
                        </p>
                    </div>
                    @endif

                    <div>
                        <p class="text-sm text-gray-400 mb-1">Joined Date</p>
                        <p class="text-gray-100 flex items-center gap-2">
                            <i class="ri-calendar-line text-gray-500"></i>
                            {{ $client->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects List -->
        <div class="lg:col-span-2">
            <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
                <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Projects</h3>
                    <a href="{{ route('admin.projects.create', ['client_id' => $client->id]) }}" 
                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center gap-2">
                        <i class="ri-add-line"></i>
                        Add Project
                    </a>
                </div>
                <div class="p-6">
                    @if($projects->count() > 0)
                        <div class="space-y-4">
                            @foreach($projects as $project)
                            <div class="bg-dark-primary rounded-xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-lg font-medium">{{ $project->name }}</h4>
                                                <span class="px-2 py-1 rounded-full text-xs 
                                                    {{ $project->status === 'completed' ? 'bg-green-500/10 text-green-500' : 
                                                       ($project->status === 'in_progress' ? 'bg-blue-500/10 text-blue-500' : 'bg-yellow-500/10 text-yellow-500') }}">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </div>
                                            <div class="mt-2 space-y-1">
                                                <p class="text-sm text-gray-400">
                                                    <i class="ri-money-dollar-circle-line mr-1"></i>
                                                    Price: Rp {{ number_format($project->price, 0, ',', '.') }}
                                                </p>
                                                <p class="text-sm text-gray-400">
                                                    <i class="ri-wallet-line mr-1"></i>
                                                    Payments: Rp {{ number_format($project->payments->sum('amount'), 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.projects.show', $project) }}" 
                                           class="px-3 py-1 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors inline-flex items-center gap-2">
                                            <i class="ri-arrow-right-line"></i>
                                            Payment
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-800 rounded-full mx-auto flex items-center justify-center mb-4">
                                <i class="ri-folder-line text-3xl text-gray-600"></i>
                            </div>
                            <p class="text-gray-400">No projects found for this client.</p>
                            <a href="{{ route('admin.projects.create', ['client_id' => $client->id]) }}" 
                               class="mt-4 inline-flex items-center gap-2 text-blue-500 hover:text-blue-400 transition-colors">
                                <i class="ri-add-line"></i>
                                Create First Project
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2"
     x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)"
     x-transition>
    <i class="ri-check-line"></i>
    {{ session('success') }}
</div>
@endif
@endsection 