@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold">{{ isset($client) ? 'Edit Client' : 'Add New Client' }}</h2>
            <p class="text-gray-400 mt-1">{{ isset($client) ? 'Update client information' : 'Add a new client to the system' }}</p>
        </div>

        <form action="{{ isset($client) ? route('admin.clients.update', $client) : route('admin.clients.store') }}" 
              method="POST"
              class="p-6 space-y-6">
            @csrf
            @if(isset($client))
                @method('PUT')
            @endif

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-300">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $client->name ?? '') }}"
                       class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                              text-gray-100"
                       required>
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
                    <span class="absolute left-4 top-2.5 text-gray-500">+62</span>
                    <input type="text" 
                           name="whatsapp" 
                           id="whatsapp" 
                           value="{{ old('whatsapp', $client->whatsapp ?? '') }}"
                           class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
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
                <textarea name="address" 
                          id="address" 
                          rows="3"
                          class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                 text-gray-100">{{ old('address', $client->address ?? '') }}</textarea>
                @error('address')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <label for="notes" class="block text-sm font-medium text-gray-300">Notes</label>
                <textarea name="notes" 
                          id="notes" 
                          rows="3"
                          class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                 text-gray-100">{{ old('notes', $client->notes ?? '') }}</textarea>
                @error('notes')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.clients.index') }}" 
                   class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    {{ isset($client) ? 'Update Client' : 'Add Client' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 