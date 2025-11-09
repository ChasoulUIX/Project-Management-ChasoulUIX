@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back Button -->
    <div>
        <a href="javascript:history.back()" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
            <i class="ri-arrow-left-line"></i>
            <span>Back to Projects</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold text-white">{{ isset($project) ? 'Edit Project' : 'Create New Project' }}</h2>
            <p class="text-gray-400 mt-1">Fill in the information below to create a new project</p>
        </div>

        <form action="{{ isset($project) ? route('admin.projects.update', $project) : route('admin.projects.store') }}" 
              method="POST"
              class="p-6 space-y-6">
            @csrf
            @if(isset($project))
                @method('PUT')
            @endif

            <!-- Project Name -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-300">
                    Project Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $project->name ?? '') }}"
                           class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100 placeholder-gray-500"
                           placeholder="Enter project name">
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <i class="ri-folder-line"></i>
                    </span>
                </div>
                @error('name')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div class="space-y-2">
                <label for="display_price" class="block text-sm font-medium text-gray-300">
                    Price (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500">Rp</span>
                    <input type="text" 
                           id="display_price" 
                           value="{{ old('price', isset($project) ? number_format($project->price, 0, ',', '.') : '') }}"
                           class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100 placeholder-gray-500"
                           placeholder="0"
                           oninput="formatPrice(this)">
                    <input type="hidden" name="price" id="real_price" value="{{ old('price', $project->price ?? '') }}">
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <i class="ri-money-dollar-circle-line"></i>
                    </span>
                </div>
                @error('price')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <label for="status" class="block text-sm font-medium text-gray-300">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="status" 
                            id="status" 
                            class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                   text-gray-100 appearance-none">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" 
                                    {{ (old('status', $project->status ?? '') == $value) ? 'selected' : '' }}
                                    class="bg-dark-primary">
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <span class="absolute right-3 top-2.5 text-gray-500 pointer-events-none">
                        <i class="ri-arrow-down-s-line"></i>
                    </span>
                </div>
                @error('status')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <label for="notes" class="block text-sm font-medium text-gray-300">
                    Notes
                </label>
                <div class="relative">
                    <textarea name="notes" 
                              id="notes" 
                              rows="4"
                              class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                     focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                     text-gray-100 placeholder-gray-500"
                              placeholder="Add any additional notes here">{{ old('notes', $project->notes ?? '') }}</textarea>
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <i class="ri-file-text-line"></i>
                    </span>
                </div>
                @error('notes')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Client -->
            <div class="space-y-2">
                <label for="client_id" class="block text-sm font-medium text-gray-300">
                    Client <span class="text-red-500">*</span>
                </label>
                <select name="client_id" 
                        id="client_id" 
                        class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                               text-gray-100"
                        required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" 
                                {{ (old('client_id', $selectedClientId ?? '') == $client->id) ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-700/50">
                <a href="javascript:history.back()" 
                   class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 
                          transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <i class="ri-close-line mr-1"></i>
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 
                               transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500
                               inline-flex items-center gap-2">
                    <i class="ri-save-line"></i>
                    {{ isset($project) ? 'Update Project' : 'Create Project' }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Success Message -->
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

@push('scripts')
<script>
function formatPrice(input) {
    // Hapus semua karakter selain angka
    let value = input.value.replace(/\D/g, '');
    
    // Format dengan pemisah ribuan
    value = new Intl.NumberFormat('id-ID').format(value);
    
    // Update tampilan input
    input.value = value;
    
    // Update nilai sebenarnya (tanpa format) untuk dikirim ke server
    document.getElementById('real_price').value = value.replace(/\D/g, '');
}
</script>
@endpush
@endsection 