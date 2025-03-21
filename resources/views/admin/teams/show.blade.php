@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.teams.index') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
            <i class="ri-arrow-left-line"></i>
            <span>Back to Team List</span>
        </a>
    </div>

    <!-- Team Info Card -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-semibold text-white">{{ $team->name }}</h2>
                    <a href="https://wa.me/{{ $team->formatted_whatsapp }}" 
                       target="_blank"
                       class="text-gray-400 hover:text-green-500 transition-colors inline-flex items-center gap-1 mt-1">
                        <i class="ri-whatsapp-line"></i>
                        {{ $team->whatsapp }}
                    </a>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.teams.edit', $team) }}" 
                       class="px-4 py-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500/20 transition-colors">
                        <i class="ri-edit-line mr-1"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
            <div class="bg-dark-primary rounded-xl p-4">
                <p class="text-sm text-gray-400">Total Projects</p>
                <p class="text-2xl font-bold mt-1">{{ $team->projects->count() }}</p>
            </div>
            <div class="bg-dark-primary rounded-xl p-4">
                <p class="text-sm text-gray-400">Total Paid</p>
                <p class="text-2xl font-bold text-green-500 mt-1">Rp {{ number_format($totalPaidSalary, 0, ',', '.') }}</p>
            </div>
            <div class="bg-dark-primary rounded-xl p-4">
                <p class="text-sm text-gray-400">Total Unpaid</p>
                <p class="text-2xl font-bold text-red-500 mt-1">Rp {{ number_format($totalUnpaidSalary, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Projects List -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Projects</h3>
            <button onclick="openAddProjectModal()" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center gap-2">
                <i class="ri-add-line"></i>
                Add Project
            </button>
        </div>
        <div class="p-6 space-y-4">
            @foreach($team->projects as $project)
            <div class="bg-dark-primary rounded-xl p-4 flex justify-between items-center">
                <div>
                    <h4 class="font-medium">{{ $project->name }}</h4>
                    <p class="text-sm text-gray-400 mt-1">Salary: Rp {{ number_format($project->pivot->salary, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 rounded-full text-sm {{ $project->pivot->status === 'paid' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                        {{ ucfirst($project->pivot->status) }}
                    </span>
                    @if($project->pivot->status === 'unpaid')
                    <form action="{{ route('admin.teams.mark-project-as-paid', ['team' => $team, 'project' => $project]) }}" 
                          method="POST"
                          class="inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="px-3 py-1 bg-green-500/10 text-green-500 rounded-lg hover:bg-green-500/20 transition-colors">
                            <i class="ri-checkbox-circle-line mr-1"></i>
                            Mark as Paid
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @if($team->notes)
    <!-- Notes -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h3 class="text-lg font-semibold">Notes</h3>
        </div>
        <div class="p-6">
            <p class="text-gray-400">{{ $team->notes }}</p>
        </div>
    </div>
    @endif
</div>

<!-- Add Project Modal -->
<div x-data="{ show: false }" 
     x-show="show"
     x-on:open-add-project-modal.window="show = true"
     x-on:close-add-project-modal.window="show = false"
     x-transition
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50" x-on:click="show = false"></div>

        <!-- Modal Content -->
        <div class="relative bg-dark-secondary rounded-2xl border border-gray-700/50 w-full max-w-md p-6 space-y-6">
            <h3 class="text-xl font-semibold">Add Project for {{ $team->name }}</h3>
            
            <form action="{{ route('admin.teams.add-project', $team) }}" method="POST">
                @csrf
                
                <!-- Project Selection -->
                <div class="space-y-2 mb-4">
                    <label class="block text-sm font-medium text-gray-300">
                        Project <span class="text-red-500">*</span>
                    </label>
                    <select name="project_id" 
                            class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                   text-gray-100"
                            required>
                        <option value="">Select Project</option>
                        @foreach($availableProjects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Salary -->
                <div class="space-y-2 mb-6">
                    <label class="block text-sm font-medium text-gray-300">
                        Salary (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-gray-500">Rp</span>
                        <input type="text" 
                               id="display_salary" 
                               class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                      text-gray-100"
                               placeholder="10.000"
                               oninput="formatSalary(this)"
                               required>
                        <input type="hidden" name="salary" id="real_salary">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-4">
                    <button type="button" 
                            x-on:click="show = false"
                            class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Add Project
                    </button>
                </div>
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

@if(session('error'))
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg">
    {{ session('error') }}
</div>
@endif

@push('scripts')
<script>
function openAddProjectModal() {
    window.dispatchEvent(new CustomEvent('open-add-project-modal'));
}

function formatSalary(input) {
    // Hapus semua karakter selain angka
    let value = input.value.replace(/\D/g, '');
    
    // Format dengan pemisah ribuan
    value = new Intl.NumberFormat('id-ID').format(value);
    
    // Update tampilan input
    input.value = value;
    
    // Update nilai sebenarnya untuk dikirim ke server
    document.getElementById('real_salary').value = value.replace(/\D/g, '');
}
</script>
@endpush

@endsection 