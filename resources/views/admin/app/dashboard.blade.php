@extends('admin.layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Projects -->
        <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-folder-line text-2xl text-blue-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Projects</p>
                    <h3 class="text-2xl font-bold">{{ \App\Models\Project::count() }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-gray-400">
                <i class="ri-file-list-line"></i>
                <span class="text-sm">All time projects</span>
            </div>
        </div>

        <!-- Active Projects -->
        <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-green-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-time-line text-2xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Active Projects</p>
                    <h3 class="text-2xl font-bold">{{ \App\Models\Project::where('status', 'process')->count() }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-green-500">
                <i class="ri-arrow-right-circle-line"></i>
                <span class="text-sm">In progress</span>
            </div>
        </div>

        <!-- Total Income -->
        <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-2xl text-purple-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Income</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format(\App\Models\Payment::sum('amount'), 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-purple-500">
                <i class="ri-wallet-line"></i>
                <span class="text-sm">Total payments received</span>
            </div>
        </div>

        <!-- Pending Projects -->
        <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-yellow-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-timer-line text-2xl text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Pending Projects</p>
                    <h3 class="text-2xl font-bold">{{ \App\Models\Project::where('status', 'pending')->count() }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-yellow-500">
                <i class="ri-hourglass-line"></i>
                <span class="text-sm">Awaiting action</span>
            </div>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Projects -->
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
            <div class="p-6 border-b border-gray-700/50">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Latest Projects</h2>
                    <a href="{{ route('admin.projects.index') }}" 
                       class="px-4 py-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500/20 transition-colors">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6 space-y-4">
                @foreach(\App\Models\Project::latest()->take(5)->get() as $project)
                <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl hover:bg-gray-800 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center">
                            <i class="ri-folder-line text-blue-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">{{ $project->name }}</h3>
                            <p class="text-sm text-gray-400">Rp {{ number_format($project->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-xs {{ $project->getStatusColorClass() }}">
                            {{ ucfirst($project->status) }}
                        </span>
                        <a href="{{ route('admin.projects.show', $project) }}" 
                           class="p-2 text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
            <div class="p-6 border-b border-gray-700/50">
                <h2 class="text-xl font-semibold">Recent Payments</h2>
            </div>
            <div class="p-6 space-y-4">
                @foreach(\App\Models\Payment::with('project')->latest()->take(5)->get() as $payment)
                <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl hover:bg-gray-800 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-green-500/10 flex items-center justify-center">
                            <i class="ri-money-dollar-circle-line text-green-500"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">{{ $payment->project->name }}</h3>
                            <p class="text-sm text-gray-400">
                                {{ $payment->payment_method }} • {{ $payment->payment_date->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-green-500">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Project Status Distribution -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-xl font-semibold">Project Status Distribution</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $statuses = [
                        'pending' => ['icon' => 'ri-timer-line', 'color' => 'yellow'],
                        'process' => ['icon' => 'ri-time-line', 'color' => 'blue'],
                        'success' => ['icon' => 'ri-check-line', 'color' => 'green'],
                        'cancel' => ['icon' => 'ri-close-circle-line', 'color' => 'red']
                    ];
                @endphp

                @foreach($statuses as $status => $info)
                @php
                    $count = \App\Models\Project::where('status', $status)->count();
                @endphp
                <div class="p-4 bg-gray-800/50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-{{ $info['color'] }}-500/10 flex items-center justify-center">
                            <i class="{{ $info['icon'] }} text-{{ $info['color'] }}-500"></i>
                        </div>
                        <span class="text-sm font-medium">{{ ucfirst($status) }}</span>
                    </div>
                    <p class="text-2xl font-bold mt-2">{{ $count }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
