@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6 space-y-4 md:space-y-6">
    <!-- Client Info -->
    <div class="bg-dark-secondary/95 md:bg-dark-secondary/80 rounded-xl md:rounded-2xl border border-gray-700/50 p-4 md:p-6 relative overflow-hidden">
        <div class="flex items-center gap-3 md:gap-4 relative">
            <div class="w-12 h-12 md:w-16 md:h-16 bg-blue-500/10 rounded-xl flex items-center justify-center shrink-0">
                <i class="ri-user-line text-xl md:text-2xl text-blue-500"></i>
            </div>
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-white">
                    {{ $client->name }}
                </h2>
                <a href="https://wa.me/{{ $client->whatsapp }}" target="_blank" 
                   class="text-sm md:text-base text-gray-400 flex items-center gap-2 hover:text-green-500 transition-colors mt-0.5">
                    <i class="ri-whatsapp-line"></i>
                    {{ $client->whatsapp }}
                </a>
            </div>
        </div>
    </div>

    <!-- Projects List -->
    <div class="space-y-4 md:space-y-6">
        @forelse($client->projects as $project)
            <div class="bg-dark-secondary/95 md:bg-dark-secondary/80 rounded-xl md:rounded-2xl border border-gray-700/50 overflow-hidden">
                <!-- Project Header -->
                <div class="p-4 md:p-6 border-b border-gray-700/50">
                    <div class="flex flex-col md:flex-row justify-between md:items-center gap-3 md:gap-4">
                        <div>
                            <h3 class="text-lg md:text-xl font-semibold text-white">{{ $project->name }}</h3>
                            <p class="text-xs md:text-sm text-gray-400 mt-1 flex items-center gap-2">
                                <i class="ri-calendar-line"></i>
                                Created: {{ $project->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <span class="self-start px-3 py-1 rounded-full text-xs md:text-sm inline-flex items-center gap-1.5 {{ 
                            match($project->status) {
                                'success' => 'bg-green-500/10 text-green-500',
                                'pending' => 'bg-yellow-500/10 text-yellow-500',
                                'process' => 'bg-blue-500/10 text-blue-500',
                                'cancel' => 'bg-red-500/10 text-red-500',
                                default => 'bg-gray-500/10 text-gray-500'
                            }
                        }}">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>
                </div>

                <div class="p-4 md:p-6 space-y-4 md:space-y-6">
                    <!-- Progress Bar -->
                    <div class="bg-dark-primary rounded-lg p-3 md:p-4">
                        <div class="flex flex-col md:flex-row justify-between md:items-end gap-2 md:gap-4 mb-3">
                            <div>
                                <p class="text-xs md:text-sm text-gray-400">Payment Progress</p>
                                <p class="text-base md:text-lg font-semibold mt-0.5 md:mt-1">
                                    <span class="text-white">
                                        Rp {{ number_format($project->total_paid, 0, ',', '.') }}
                                    </span>
                                    <span class="text-gray-400 text-sm md:text-base">/ Rp {{ number_format($project->price, 0, ',', '.') }}</span>
                                </p>
                            </div>
                            <p class="text-base md:text-lg {{ $project->payment_progress == 100 ? 'text-green-500' : 'text-blue-500' }} font-medium">
                                {{ number_format($project->payment_progress, 1) }}%
                            </p>
                        </div>
                        <div class="h-2 md:h-3 bg-gray-700/50 rounded-full overflow-hidden">
                            <div class="h-full {{ $project->payment_progress == 100 ? 'bg-green-500' : 'bg-blue-500' }} transition-all duration-500"
                                 style="width: {{ $project->payment_progress }}%"></div>
                        </div>
                    </div>

                    <!-- Payment History -->
                    @if($project->payments->count() > 0)
                        <div>
                            <h4 class="text-base md:text-lg font-semibold mb-3 flex items-center gap-2 text-white">
                                <i class="ri-money-dollar-circle-line text-blue-500"></i>
                                Payment History
                            </h4>
                            <div class="space-y-2 md:space-y-3">
                                @foreach($project->payments as $payment)
                                    <div class="bg-dark-primary rounded-lg p-3 md:p-4">
                                        <div class="flex flex-col md:flex-row justify-between md:items-center gap-2 md:gap-3">
                                            <div>
                                                <p class="font-medium text-base md:text-lg text-white">
                                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                                </p>
                                                <p class="text-xs md:text-sm text-gray-400 flex items-center gap-1.5">
                                                    <i class="ri-bank-card-line"></i>
                                                    {{ $payment->payment_method }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs md:text-sm text-gray-400 flex items-center gap-1.5 justify-end">
                                                    <i class="ri-calendar-line"></i>
                                                    {{ $payment->payment_date->format('d M Y') }}
                                                </p>
                                                @if($payment->notes)
                                                    <p class="text-xs text-gray-500 mt-0.5">{{ $payment->notes }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-dark-secondary/95 md:bg-dark-secondary/80 rounded-xl md:rounded-2xl border border-gray-700/50 p-6 md:p-8">
                <div class="text-center text-gray-400">
                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-800/50 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="ri-folder-line text-2xl md:text-3xl"></i>
                    </div>
                    <p class="text-sm md:text-base">No projects found</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Back Button -->
    <div class="mt-6 md:mt-8">
        <a href="{{ route('users.projects.check') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
            <span class="w-8 h-8 bg-dark-secondary rounded-lg flex items-center justify-center">
                <i class="ri-arrow-left-line"></i>
            </span>
            <span class="text-sm md:text-base">Check Another Number</span>
        </a>
    </div>
</div>

<style>
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-in {
    animation: slideIn 0.3s ease-out forwards;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const projects = document.querySelectorAll('.bg-dark-secondary');
    projects.forEach((project, index) => {
        project.style.opacity = '0';
        project.style.animation = `slideIn 0.3s ease-out ${index * 0.1}s forwards`;
    });
});
</script>
@endsection 