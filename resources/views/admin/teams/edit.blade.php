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
            <h2 class="text-2xl font-semibold">Edit Team Member</h2>
            <p class="text-gray-400 mt-1">Update team member information</p>
        </div>

        <form action="{{ route('admin.teams.update', $team) }}" 
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
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $team->name) }}"
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
                           value="{{ old('whatsapp', $team->whatsapp) }}"
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

            <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.teams.index') }}" 
                   class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Update Team Member
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-dark-secondary rounded-2xl border border-red-500/10">
        <div class="p-6">
            <h3 class="text-lg font-medium text-red-500">Danger Zone</h3>
            <p class="mt-1 text-sm text-gray-400">Once you delete a team member, there is no going back.</p>
            
            <form action="{{ route('admin.teams.destroy', $team) }}" 
                  method="POST" 
                  class="mt-4"
                  onsubmit="return confirm('Are you sure you want to delete this team member? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-500/10 text-red-500 rounded-lg hover:bg-red-500/20 
                               transition-colors focus:outline-none focus:ring-2 focus:ring-red-500">
                    <i class="ri-delete-bin-line mr-1"></i>
                    Delete Team Member
                </button>
            </form>
        </div>
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
@endsection 