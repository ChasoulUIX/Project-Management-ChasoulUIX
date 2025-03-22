@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
        <h2 class="text-2xl font-semibold">Projects Management</h2>
        <a href="{{ route('admin.projects.create') }}" 
           class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-center">
            <i class="ri-add-line mr-1"></i> Add Project
        </a>
    </div>

    <!-- Projects Table -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="overflow-x-auto">
            <!-- Mobile View -->
            <div class="block sm:hidden">
                @foreach($projects as $project)
                <div class="p-4 border-b border-gray-700/50 hover:bg-gray-800/50 transition-colors">
                    <div class="space-y-3">
                        <!-- Project Name & Status -->
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <h3 class="font-medium">{{ $project->name }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs {{ $project->getStatusColorClass() }} inline-block">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                            <p class="text-sm font-medium">
                                Rp {{ number_format($project->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Payment Progress -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs text-gray-400">
                                <span>Payment Progress</span>
                                <span>{{ number_format($project->payment_progress, 1) }}%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full {{ $project->payment_progress == 100 ? 'bg-green-500' : 'bg-blue-500' }}"
                                     style="width: {{ $project->payment_progress }}%">
                                </div>
                            </div>
                        </div>

                        <!-- Date & Actions -->
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-sm text-gray-400">{{ $project->created_at->format('d M Y') }}</span>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.projects.show', $project) }}" 
                                   class="p-2 bg-gray-600/50 text-gray-300 rounded hover:bg-gray-600 transition-colors">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" 
                                   class="p-2 bg-blue-500/10 text-blue-500 rounded hover:bg-blue-500/20 transition-colors">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" 
                                      method="POST" 
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition-colors"
                                            onclick="return confirm('Are you sure you want to delete this project?')">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Desktop View -->
            <table class="w-full hidden sm:table">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="px-6 py-4 text-left">Name</th>
                        <th class="px-6 py-4 text-left">Price</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Payment Progress</th>
                        <th class="px-6 py-4 text-left">Created</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">{{ $project->name }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($project->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs {{ $project->getStatusColorClass() }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 h-2 bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full {{ $project->payment_progress == 100 ? 'bg-green-500' : 'bg-blue-500' }}"
                                         style="width: {{ $project->payment_progress }}%"></div>
                                </div>
                                <span class="text-xs text-gray-400">
                                    {{ number_format($project->payment_progress, 1) }}%
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $project->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <!-- View Button -->
                            <a href="{{ route('admin.projects.show', $project) }}" 
                               class="px-3 py-1 bg-gray-600/50 text-gray-300 rounded hover:bg-gray-600 transition-colors">
                                <i class="ri-eye-line"></i> View
                            </a>
                            
                            <!-- Edit Button -->
                            <a href="{{ route('admin.projects.edit', $project) }}" 
                               class="px-3 py-1 bg-blue-500/10 text-blue-500 rounded hover:bg-blue-500/20 transition-colors">
                                <i class="ri-edit-line"></i> Edit
                            </a>
                            
                            <!-- Delete Button -->
                            <form action="{{ route('admin.projects.destroy', $project) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this project?')">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4">
            {{ $projects->links() }}
        </div>
    </div>
</div>

<!-- Success Message -->
<div class="fixed bottom-4 right-4 left-4 sm:left-auto bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2"
     x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)"
     x-transition>
    <i class="ri-check-line"></i>
    {{ session('success') }}
</div>
@endsection 