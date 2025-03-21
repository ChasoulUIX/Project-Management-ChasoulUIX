@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.teams.index') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
            <i class="ri-arrow-left-line"></i>
            <span>Back to Team List</span>
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold text-white">Edit Team Member</h2>
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
                           class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100 placeholder-gray-500"
                           placeholder="Enter team member name"
                           required>
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <i class="ri-user-line"></i>
                    </span>
                </div>
                @error('name')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-300">
                    Email <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $team->email) }}"
                           class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100 placeholder-gray-500"
                           placeholder="Enter email address"
                           required>
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <i class="ri-mail-line"></i>
                    </span>
                </div>
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Project -->
            <div class="space-y-2">
                <label for="project_id" class="block text-sm font-medium text-gray-300">
                    Project <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="project_id" 
                            id="project_id" 
                            class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                   text-gray-100 appearance-none"
                            required>
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                    {{ (old('project_id', $team->project_id) == $project->id) ? 'selected' : '' }}
                                    class="bg-dark-primary">
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="absolute right-3 top-2.5 text-gray-500 pointer-events-none">
                        <i class="ri-arrow-down-s-line"></i>
                    </span>
                </div>
                @error('project_id')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Salary -->
            <div class="space-y-2">
                <label for="salary" class="block text-sm font-medium text-gray-300">
                    Salary (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500">Rp</span>
                    <input type="number" 
                           name="salary" 
                           id="salary" 
                           value="{{ old('salary', $team->salary) }}"
                           class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100"
                           required>
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <i class="ri-money-dollar-circle-line"></i>
                    </span>
                </div>
                @error('salary')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <label for="notes" class="block text-sm font-medium text-gray-300">Notes</label>
                <div class="relative">
                    <textarea name="notes" 
                              id="notes" 
                              rows="4"
                              class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                     focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                     text-gray-100 placeholder-gray-500"
                              placeholder="Add any additional notes">{{ old('notes', $team->notes) }}</textarea>
                    <span class="absolute right-3 top-2.5 text-gray-500">
                        <i class="ri-file-text-line"></i>
                    </span>
                </div>
                @error('notes')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Status -->
            <div class="p-4 bg-dark-primary rounded-lg border border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-300">Payment Status</p>
                        <p class="text-xs text-gray-500 mt-1">Current status: 
                            <span class="px-2 py-1 rounded-full text-xs {{ $team->getStatusColorClass() }}">
                                {{ ucfirst($team->status) }}
                            </span>
                        </p>
                    </div>
                    @if($team->status === 'unpaid')
                    <form action="{{ route('admin.teams.mark-as-paid', $team) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="px-4 py-2 bg-green-500/10 text-green-500 rounded-lg hover:bg-green-500/20 
                                       transition-colors focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="ri-check-line mr-1"></i>
                            Mark as Paid
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-700/50">
                <a href="{{ route('admin.teams.index') }}" 
                   class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 
                          transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 
                               transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Team Member
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-dark-secondary rounded-2xl border border-red-500/10 overflow-hidden">
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
@endsection 