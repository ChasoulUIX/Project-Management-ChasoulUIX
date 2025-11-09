@extends('admin.layouts.app')

@section('content')
<div class="space-y-6" x-data="projectFilter()">
    <!-- Filter & Search Section -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-dark-secondary/70 p-4 rounded-2xl border border-gray-700/50 shadow-lg mb-2">
    <div class="flex gap-2 w-full sm:w-auto items-center">
        <!-- Status Filter -->
        <div class="relative">
            <select x-model="status" class="appearance-none px-4 py-2 pr-10 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                <option value="">All Status</option>
                <template x-for="s in statuses" :key="s">
                    <option :value="s" x-text="s.charAt(0).toUpperCase() + s.slice(1)"></option>
                </template>
            </select>
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                <i class="ri-filter-3-line"></i>
            </span>
        </div>
    </div>
    <!-- Search Bar -->
    <div class="relative w-full sm:w-64">
        <input x-model="search" type="text" placeholder="Search projects..."
               class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-sm placeholder-gray-400"
        >
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
            <i class="ri-search-line"></i>
        </span>
    </div>
</div>
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
        <h2 class="text-2xl font-semibold">Projects Management</h2>
        <a href="{{ route('admin.projects.create') }}" 
           class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-center">
            <i class="ri-add-line mr-1"></i> Add Project
        </a>
    </div>

    <!-- Projects Table (filtered by Alpine.js) -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="overflow-x-auto">
            <!-- Mobile View (filtered) -->
<div class="block sm:hidden">
    <template x-for="project in filteredProjects" :key="project.id">
        <div class="p-4 border-b border-gray-700/50 hover:bg-gray-800/50 transition-colors">
            <div class="space-y-3">
                <!-- Project Name & Status -->
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <h3 class="font-medium" x-text="project.name"></h3>
                        <span class="px-3 py-1 rounded-full text-xs" :class="project.status_color_class + ' inline-block'">
                            <span x-text="project.status.charAt(0).toUpperCase() + project.status.slice(1)"></span>
                        </span>
                    </div>
                    <p class="text-sm font-medium">
                        Rp <span x-text="project.price_formatted"></span>
                    </p>
                </div>
                <!-- Payment Progress -->
                <div class="space-y-1">
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span>Payment Progress</span>
                        <span x-text="project.payment_progress.toFixed(1) + '%' "></span>
                    </div>
                    <div class="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full" :class="project.payment_progress == 100 ? 'bg-green-500' : 'bg-blue-500'" :style="'width: ' + project.payment_progress + '%'">
                        </div>
                    </div>
                </div>
                <!-- Date & Actions -->
                <div class="flex items-center justify-between pt-2">
                    <span class="text-sm text-gray-400" x-text="project.created_at"></span>
                    <div class="flex gap-2">
                        <a :href="project.show_url" class="p-2 bg-gray-600/50 text-gray-300 rounded hover:bg-gray-600 transition-colors">
                            <i class="ri-eye-line"></i>
                        </a>
                        <a :href="project.edit_url" class="p-2 bg-blue-500/10 text-blue-500 rounded hover:bg-blue-500/20 transition-colors">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form :action="project.delete_url" method="POST" class="inline-block">
                            <input type="hidden" name="_token" :value="project.csrf">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="p-2 bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition-colors"
                                    onclick="return confirm('Are you sure you want to delete this project?')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <template x-if="filteredProjects.length === 0">
        <div class="p-4 text-center text-gray-400">No projects found.</div>
    </template>
</div>

            <!-- Desktop View (filtered) -->
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
        <template x-for="project in filteredProjects" :key="project.id">
            <tr class="border-b border-gray-700/50 hover:bg-gray-800/50 transition-colors">
                <td class="px-6 py-4" x-text="project.name"></td>
                <td class="px-6 py-4">Rp <span x-text="project.price_formatted"></span></td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs" :class="project.status_color_class">
                        <span x-text="project.status.charAt(0).toUpperCase() + project.status.slice(1)"></span>
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-24 h-2 bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full" :class="project.payment_progress == 100 ? 'bg-green-500' : 'bg-blue-500'" :style="'width: ' + project.payment_progress + '%' "></div>
                        </div>
                        <span class="text-xs text-gray-400" x-text="project.payment_progress.toFixed(1) + '%' "></span>
                    </div>
                </td>
                <td class="px-6 py-4" x-text="project.created_at"></td>
                <td class="px-6 py-4 text-right space-x-2">
                    <!-- View Button -->
                    <a :href="project.show_url" class="px-3 py-1 bg-gray-600/50 text-gray-300 rounded hover:bg-gray-600 transition-colors">
                        <i class="ri-eye-line"></i> View
                    </a>
                    <!-- Edit Button -->
                    <a :href="project.edit_url" class="px-3 py-1 bg-blue-500/10 text-blue-500 rounded hover:bg-blue-500/20 transition-colors">
                        <i class="ri-edit-line"></i> Edit
                    </a>
                    <!-- Delete Button -->
                    <form :action="project.delete_url" method="POST" class="inline-block">
                        <input type="hidden" name="_token" :value="project.csrf">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="px-3 py-1 bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition-colors"
                                onclick="return confirm('Are you sure you want to delete this project?')">
                            <i class="ri-delete-bin-line"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        </template>
        <template x-if="filteredProjects.length === 0">
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-400">No projects found.</td>
            </tr>
        </template>
    </tbody>
</table>
        </div>
        
        <!-- Message when filtering with no results -->
        <div class="p-4 text-center text-gray-400" x-show="filteredProjects.length === 0">
            No projects found matching your filters.
        </div>
        
        <!-- Total Results -->
        <div class="p-4 border-t border-gray-700/50 text-sm text-gray-400">
            Showing <span x-text="filteredProjects.length"></span> of <span x-text="projects.length"></span> projects
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
@php
    $csrf_token = csrf_token();
    $projectsArray = $projects->map(function($project) use ($csrf_token) {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'price' => $project->price,
            'price_formatted' => number_format($project->price, 0, ',', '.'),
            'status' => $project->status,
            'status_color_class' => $project->getStatusColorClass(),
            'payment_progress' => $project->payment_progress,
            'created_at' => $project->created_at->format('d M Y'),
            'show_url' => route('admin.projects.show', $project),
            'edit_url' => route('admin.projects.edit', $project),
            'delete_url' => route('admin.projects.destroy', $project),
            'csrf' => $csrf_token,
        ];
    });
@endphp
<script>
function projectFilter() {
    return {
        search: '',
        status: '',
        projects: @json($projectsArray),
        get statuses() {
            // Unique status values from all projects
            return [...new Set(this.projects.map(p => p.status))];
        },
        get filteredProjects() {
            return this.projects.filter(project => {
                const matchesStatus = this.status === '' || project.status === this.status;
                const matchesSearch = this.search === '' || project.name.toLowerCase().includes(this.search.toLowerCase());
                return matchesStatus && matchesSearch;
            });
        }
    };
}
</script>
@endsection 