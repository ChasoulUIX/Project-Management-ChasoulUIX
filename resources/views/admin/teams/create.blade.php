@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.teams.index') }}" 
       class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
        <i class="ri-arrow-left-line"></i>
        Back to Team Members
    </a>

    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold">Add Team Member</h2>
            <p class="text-gray-400 mt-1">Create a new team member</p>
        </div>

        <form action="{{ route('admin.teams.store') }}" 
              method="POST"
              class="p-6 space-y-6">
            @csrf

            <!-- Name -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-gray-300">
                    Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full pl-10 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100"
                           placeholder="Enter team member name"
                           required>
                    <span class="absolute left-3 top-2.5 text-gray-500">
                        <i class="ri-user-line"></i>
                    </span>
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
                    <span class="absolute left-4 top-2.5 text-gray-500">+62</span>
                    <input type="text" 
                           name="whatsapp" 
                           id="whatsapp" 
                           value="{{ old('whatsapp') }}"
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

            <!-- Project -->
            <div class="space-y-2">
                <label for="project_id" class="block text-sm font-medium text-gray-300">
                    Project <span class="text-red-500">*</span>
                </label>
                <select name="project_id" 
                        id="project_id"
                        class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                               text-gray-100">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Salary -->
            <div class="space-y-2">
                <label for="display_salary" class="block text-sm font-medium text-gray-300">
                    Salary <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500">Rp</span>
                    <input type="text" 
                           id="display_salary" 
                           class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100"
                           placeholder="1.000.000"
                           value="{{ old('salary') ? number_format(old('salary'), 0, ',', '.') : '' }}"
                           required>
                    <input type="hidden" 
                           name="salary" 
                           id="actual_salary" 
                           value="{{ old('salary') }}">
                </div>
                <p class="text-xs text-gray-400">Enter amount in Rupiah (IDR)</p>
                @error('salary')
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
                          class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                 text-gray-100"
                          rows="4"
                          placeholder="Add any additional notes here">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.teams.index') }}" 
                   class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Add Team Member
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg">
    {{ session('success') }}
</div>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const displaySalary = document.getElementById('display_salary');
    const actualSalary = document.getElementById('actual_salary');

    // Format awal jika ada old value
    if (displaySalary.value) {
        formatSalary(displaySalary.value);
    }

    displaySalary.addEventListener('input', function(e) {
        // Hapus semua karakter non-digit
        let value = e.target.value.replace(/\D/g, '');
        
        // Format number dengan thousand separator
        formatSalary(value);
    });

    function formatSalary(value) {
        // Simpan nilai asli ke hidden input
        actualSalary.value = value;

        // Format untuk display
        if (value === '') {
            displaySalary.value = '';
        } else {
            // Format dengan thousand separator
            displaySalary.value = new Intl.NumberFormat('id-ID').format(value);
        }
    }

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (actualSalary.value === '') {
            e.preventDefault();
            alert('Please enter a valid salary amount');
        }
    });
});
</script>
@endpush
@endsection