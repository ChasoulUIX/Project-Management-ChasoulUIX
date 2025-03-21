@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('admin.clients.index') }}" 
       class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
        <i class="ri-arrow-left-line"></i>
        Back to Clients
    </a>

    <!-- Edit Form -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold">Edit Client</h2>
            <p class="text-gray-400 mt-1">Update client information</p>
        </div>

        <form action="{{ route('admin.clients.update', $client) }}" 
              method="POST"
              class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-300">
                    Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="ri-user-line absolute left-4 top-3 text-gray-400"></i>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $client->name) }}"
                           class="w-full pl-11 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100"
                           required>
                </div>
                @error('name')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- WhatsApp -->
            <div class="space-y-2">
                <label for="whatsapp" class="block text-sm font-medium text-gray-300">
                    WhatsApp <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <i class="ri-whatsapp-line absolute left-4 top-3 text-gray-400"></i>
                    <span class="absolute left-11 top-2.5 text-gray-500">+62</span>
                    <input type="text" 
                           name="whatsapp" 
                           id="whatsapp" 
                           value="{{ old('whatsapp', $client->whatsapp) }}"
                           class="w-full pl-20 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100"
                           placeholder="8123456789"
                           required>
                </div>
                @error('whatsapp')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="space-y-2">
                <label for="address" class="block text-sm font-medium text-gray-300">Address</label>
                <div class="relative">
                    <i class="ri-map-pin-line absolute left-4 top-3 text-gray-400"></i>
                    <textarea name="address" 
                              id="address" 
                              rows="3"
                              class="w-full pl-11 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                     focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                     text-gray-100">{{ old('address', $client->address) }}</textarea>
                </div>
                @error('address')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <label for="notes" class="block text-sm font-medium text-gray-300">Notes</label>
                <div class="relative">
                    <i class="ri-file-text-line absolute left-4 top-3 text-gray-400"></i>
                    <textarea name="notes" 
                              id="notes" 
                              rows="3"
                              class="w-full pl-11 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                     focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                     text-gray-100">{{ old('notes', $client->notes) }}</textarea>
                </div>
                @error('notes')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Projects Summary -->
            <div class="p-4 bg-gray-800/50 rounded-xl space-y-3">
                <h3 class="font-medium flex items-center gap-2">
                    <i class="ri-folder-line text-blue-500"></i>
                    Projects Summary
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Total Projects</p>
                        <p class="text-lg font-semibold">{{ $client->total_projects }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Total Value</p>
                        <p class="text-lg font-semibold">Rp {{ number_format($client->total_payments, 0, ',', '.') }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.clients.show', $client) }}" 
                   class="inline-flex items-center gap-1 text-sm text-blue-500 hover:text-blue-400">
                    View Details
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4">
                <button type="button"
                        onclick="document.getElementById('deleteForm').submit()"
                        class="px-4 py-2 bg-red-500/10 text-red-500 rounded-lg hover:bg-red-500/20 transition-colors">
                    Delete Client
                </button>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.clients.index') }}" 
                       class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Update Client
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" 
          action="{{ route('admin.clients.destroy', $client) }}" 
          method="POST" 
          class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

@if(session('success'))
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg">
    {{ session('success') }}
</div>
@endif
@endsection 