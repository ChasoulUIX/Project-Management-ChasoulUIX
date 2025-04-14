@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Team Members</h2>
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
                    <p class="text-sm text-gray-400">Total Members</p>
                    <h3 class="text-2xl font-bold">{{ $teams->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-2xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Paid</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalPaidSalary, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-2xl text-red-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Unpaid</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalUnpaidSalary, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Members Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($teams as $team)
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $team->name }}</h3>
                        <a href="https://wa.me/{{ $team->formatted_whatsapp }}" 
                           target="_blank"
                           class="text-sm text-gray-400 hover:text-green-500 transition-colors inline-flex items-center gap-1">
                            <i class="ri-whatsapp-line"></i>
                            {{ $team->whatsapp }}
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.teams.edit', $team) }}" 
                           class="p-2 text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form action="{{ route('admin.teams.destroy', $team) }}" 
                              method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Projects List -->
                <div class="space-y-3">
                    @foreach($team->projects->take(3) as $project)
                    <div class="bg-dark-primary rounded-lg p-3">
                        <div class="flex justify-between items-start mb-2">
                            <p class="text-sm font-medium">{{ $project->name }}</p>
                            <span class="px-2 py-1 rounded-full text-xs {{ $project->pivot->status === 'paid' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                {{ ucfirst($project->pivot->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-400">
                            @if($project->pivot->status === 'paid')
                                Paid: Rp {{ number_format($project->pivot->amount_paid, 0, ',', '.') }}
                            @else
                                Salary: Rp {{ number_format($project->pivot->salary, 0, ',', '.') }}
                            @endif
                        </p>
                        @if($project->pivot->status === 'unpaid')
                        <form action="{{ route('admin.teams.update-payment-status', ['team' => $team, 'project' => $project]) }}" 
                              method="POST" 
                              class="mt-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="paid">
                            <input type="hidden" name="payment_date" value="{{ now() }}">
                            <button type="submit" 
                                    class="text-xs text-green-500 hover:text-green-400 transition-colors inline-flex items-center gap-1">
                                <i class="ri-checkbox-circle-line"></i>
                                Mark as Paid
                            </button>
                        </form>
                        @endif
                    </div>
                    @endforeach

                    @if($team->projects->count() > 3)
                        <div class="text-center pt-2">
                            <a href="{{ route('admin.teams.show', $team) }}" 
                               class="text-xs text-gray-400 hover:text-blue-500 transition-colors">
                                +{{ $team->projects->count() - 3 }} more projects
                            </a>
                        </div>
                    @endif
                </div>

                <a href="{{ route('admin.teams.show', $team) }}" 
                   class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-400 transition-colors mt-4">
                    View Details
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $teams->links() }}
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