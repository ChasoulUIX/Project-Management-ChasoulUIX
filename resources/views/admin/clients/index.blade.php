@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Clients</h2>
        <a href="{{ route('admin.clients.create') }}" 
           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
            <i class="ri-user-add-line mr-1"></i> Add Client
        </a>
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