@extends('admin.layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Total Income -->
      <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-money-dollar-circle-line text-2xl text-purple-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Total Income</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-purple-500">
                <i class="ri-wallet-line"></i>
                <span class="text-sm">Total payments received</span>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-green-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-line-chart-line text-2xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Net Profit</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 {{ $netProfit >= 0 ? 'text-green-500' : 'text-red-500' }}">
                <i class="ri-arrow-{{ $netProfit >= 0 ? 'up' : 'down' }}-line"></i>
                <span class="text-sm">{{ $netProfit >= 0 ? 'Profit' : 'Loss' }} after team expenses</span>
            </div>
        </div>


        <!-- Team Expenses -->
        <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-red-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-team-line text-2xl text-red-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Team Expenses</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalTeamExpenses, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-red-500">
                <i class="ri-money-dollar-circle-line"></i>
                <span class="text-sm">Total team payments</span>
            </div>
        </div>

        <!-- Outstanding Payments -->
        <div class="p-6 bg-dark-secondary rounded-2xl border border-gray-700/50 hover:border-yellow-500/50 transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center">
                    <i class="ri-funds-line text-2xl text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Outstanding Payments</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($outstandingPayments, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-yellow-500">
                <i class="ri-time-line"></i>
                <span class="text-sm">Remaining unpaid project values</span>
            </div>
        </div>
    </div>

    <!-- Recent Projects & Payments Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Latest Projects -->
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 lg:col-span-1">
            <div class="p-6 border-b border-gray-700/50">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Latest Projects</h2>
                    <a href="{{ route('admin.projects.index') }}" 
                       class="px-4 py-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500/20 transition-colors">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4 max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-800/50">
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
        </div>

        <!-- Recent Payments -->
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 lg:col-span-1">
            <div class="p-6 border-b border-gray-700/50">
                <h2 class="text-xl font-semibold">Recent Payments</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4 max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-800/50">
                    @foreach(\App\Models\Payment::with(['project' => function($query) {
                        $query->where('status', '!=', 'cancel');
                    }])
                    ->whereHas('project', function($query) {
                        $query->where('status', '!=', 'cancel');
                    })
                    ->latest()
                    ->take(5)
                    ->get() as $payment)
                        @if($payment->project)
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
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Clients -->
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 lg:col-span-1">
            <div class="p-6 border-b border-gray-700/50">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Recent Clients</h2>
                    <a href="{{ route('admin.clients.index') }}" 
                       class="px-4 py-2 bg-pink-500/10 text-pink-500 rounded-lg hover:bg-pink-500/20 transition-colors">
                        View All
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4 max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-800/50">
                    @foreach(\App\Models\Client::latest()->take(5)->get() as $client)
                    <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl hover:bg-gray-800 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-pink-500/10 flex items-center justify-center">
                                <i class="ri-user-star-line text-pink-500"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">{{ $client->name }}</h3>
                                <a href="https://wa.me/{{ $client->formatted_whatsapp }}" 
                                   target="_blank"
                                   class="text-sm text-gray-400 hover:text-green-500 transition-colors inline-flex items-center gap-1">
                                    <i class="ri-whatsapp-line"></i>
                                    {{ $client->whatsapp }}
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-400">
                                {{ $client->total_projects }} Projects
                            </span>
                            <a href="{{ route('admin.clients.show', $client) }}" 
                               class="p-2 text-gray-400 hover:text-pink-500 transition-colors">
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Project Status Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Project Status -->
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
                        // Hitung project berdasarkan status (otomatis exclude soft deleted)
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

        <!-- Client Projects Distribution -->
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
            <div class="p-6 border-b border-gray-700/50">
                <h2 class="text-xl font-semibold">Top Clients</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4 max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-800/50">
                    @foreach(\App\Models\Client::withCount('projects')
                        ->withSum('projects', 'price')
                        ->orderByDesc('projects_sum_price')
                        ->take(5)
                        ->get() as $client)
                    <div class="p-4 bg-gray-800/50 rounded-xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-pink-500/10 flex items-center justify-center">
                                    <i class="ri-user-star-line text-pink-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $client->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ $client->projects_count }} Projects</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-300">
                                    Rp {{ number_format($client->projects_sum_price ?? 0, 0, ',', '.') }}
                                </p>
                                <p class="text-sm text-gray-400">Total Value</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
