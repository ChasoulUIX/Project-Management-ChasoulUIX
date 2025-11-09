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

    <!-- Edit Form Card -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold text-white">Edit Project</h2>
            <p class="text-gray-400 mt-1">Update project information and status</p>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Project Name -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-300">
                    Project Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $project->name) }}"
                       class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                              text-gray-100 placeholder-gray-500"
                       placeholder="Enter project name">
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
                           value="{{ old('price', number_format($project->price, 0, ',', '.')) }}"
                           class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100 placeholder-gray-500"
                           placeholder="0"
                           oninput="formatPrice(this)">
                    <input type="hidden" name="price" id="real_price" value="{{ old('price', $project->price) }}">
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
                <select name="status" 
                        id="status" 
                        class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                               text-gray-100">
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" 
                                {{ (old('status', $project->status) == $value) ? 'selected' : '' }}
                                class="bg-dark-primary">
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <label for="notes" class="block text-sm font-medium text-gray-300">
                    Notes
                </label>
                <textarea name="notes" 
                          id="notes" 
                          rows="4"
                          class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                 text-gray-100 placeholder-gray-500"
                          placeholder="Add any additional notes here">{{ old('notes', $project->notes) }}</textarea>
                @error('notes')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status History (Optional) -->
            <div class="pt-6 border-t border-gray-700/50">
                <h3 class="text-lg font-medium text-white mb-4">Current Status</h3>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $project->getStatusColorClass() }}">
                    <span class="w-2 h-2 rounded-full bg-current"></span>
                    <span>{{ ucfirst($project->status) }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-700/50">
                <button type="button" 
                        onclick="history.back()"
                        class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 
                               transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 
                               transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Project
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-dark-secondary rounded-2xl border border-red-500/10 overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-medium text-red-500">Danger Zone</h3>
            <p class="mt-1 text-sm text-gray-400">Once you delete a project, there is no going back.</p>
            
            <form action="{{ route('admin.projects.destroy', $project) }}" 
                  method="POST" 
                  class="mt-4"
                  onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-500/10 text-red-500 rounded-lg hover:bg-red-500/20 
                               transition-colors focus:outline-none focus:ring-2 focus:ring-red-500">
                    <i class="ri-delete-bin-line mr-1"></i>
                    Delete Project
                </button>
            </form>
        </div>
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
    let rawValue = input.value.replace(/\D/g, '');
    
    // Update nilai sebenarnya untuk dikirim ke server (SEBELUM format)
    document.getElementById('real_price').value = rawValue;
    
    // Format dengan pemisah ribuan untuk tampilan
    let formattedValue = new Intl.NumberFormat('id-ID').format(rawValue);
    
    // Update tampilan input
    input.value = formattedValue;
}
</script>
@endpush
@endsection 