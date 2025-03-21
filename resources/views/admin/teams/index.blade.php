@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Team Management</h2>
        <a href="{{ route('admin.teams.create') }}" 
           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
            <i class="ri-user-add-line mr-1"></i> Add Team Member
        </a>
    </div>

    <!-- Team Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-team-line text-2xl text-blue-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Team Members</p>
                    <h3 class="text-2xl font-bold">{{ \App\Models\Team::count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-2xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Paid Salary</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format(\App\Models\Team::where('status', 'paid')->sum('salary'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-wallet-line text-2xl text-red-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Pending Payments</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format(\App\Models\Team::where('status', 'unpaid')->sum('salary'), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Table -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="px-6 py-4 text-left">Name</th>
                        <th class="px-6 py-4 text-left">WhatsApp</th>
                        <th class="px-6 py-4 text-left">Project</th>
                        <th class="px-6 py-4 text-left">Salary</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Payment Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $team)
                    <tr class="border-b border-gray-700/50 hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $team->name }}</span>
                                <a href="https://wa.me/{{ $team->formatted_whatsapp }}" 
                                   target="_blank"
                                   class="text-sm text-gray-400 hover:text-green-500 transition-colors inline-flex items-center gap-1">
                                    <i class="ri-whatsapp-line"></i>
                                    {{ $team->whatsapp }}
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $team->whatsapp }}</td>
                        <td class="px-6 py-4">{{ $team->project->name }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($team->salary, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs {{ $team->getStatusColorClass() }}">
                                {{ ucfirst($team->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{ $team->payment_date ? $team->payment_date->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($team->status === 'unpaid')
                            <form action="{{ route('admin.teams.mark-as-paid', $team) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-3 py-1 bg-green-500/10 text-green-500 rounded hover:bg-green-500/20 transition-colors">
                                    Mark as Paid
                                </button>
                            </form>
                            @endif
                            
                            <a href="{{ route('admin.teams.edit', $team) }}" 
                               class="px-3 py-1 bg-blue-500/10 text-blue-500 rounded hover:bg-blue-500/20 transition-colors">
                                Edit
                            </a>
                            
                            <form action="{{ route('admin.teams.destroy', $team) }}" 
                                  method="POST" 
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1 bg-red-500/10 text-red-500 rounded hover:bg-red-500/20 transition-colors"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $teams->links() }}
        </div>
    </div>
</div>
@endsection 