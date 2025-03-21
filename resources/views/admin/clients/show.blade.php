@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Client Details -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold text-white">Client Details</h2>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <h3 class="text-gray-400">Name</h3>
                <p class="text-white text-lg">{{ $client->name }}</p>
            </div>
            <div>
                <h3 class="text-gray-400">WhatsApp</h3>
                <p class="text-white text-lg">{{ $client->whatsapp }}</p>
            </div>
            @if($client->address)
            <div>
                <h3 class="text-gray-400">Address</h3>
                <p class="text-white text-lg">{{ $client->address }}</p>
            </div>
            @endif
            @if($client->notes)
            <div>
                <h3 class="text-gray-400">Notes</h3>
                <p class="text-white text-lg">{{ $client->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Projects List -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-white">Projects</h2>
            <a href="{{ route('admin.projects.create', ['client_id' => $client->id]) }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                Add Project
            </a>
        </div>
        <div class="p-6">
            @if($projects->count() > 0)
                <div class="space-y-4">
                    @foreach($projects as $project)
                    <div class="bg-dark-primary p-4 rounded-lg border border-gray-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-medium text-white">{{ $project->name }}</h3>
                                <p class="text-gray-400 mt-1">
                                    Total Payments: Rp {{ number_format($project->payments->sum('amount')) }}
                                </p>
                            </div>
                            <a href="{{ route('admin.projects.show', $project) }}" 
                               class="px-3 py-1 bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-4">No projects found for this client.</p>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.clients.edit', $client) }}" 
           class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
            Edit Client
        </a>
        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors"
                    onclick="return confirm('Are you sure you want to delete this client?')">
                Delete Client
            </button>
        </form>
    </div>
</div>
@endsection 