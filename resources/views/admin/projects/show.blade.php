@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.projects.index') }}" 
           class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
            <i class="ri-arrow-left-line"></i>
            <span>Back to Projects</span>
        </a>
    </div>

    <!-- Project Details Card -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-semibold text-white">{{ $project->name }}</h2>
                    <p class="text-gray-400 mt-1">Created {{ $project->created_at->format('d M Y') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm {{ $project->getStatusColorClass() }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>

            <!-- Project Progress -->
            <div class="mt-6">
                <div class="flex justify-between items-end mb-2">
                    <div>
                        <p class="text-sm text-gray-400">Payment Progress</p>
                        <p class="text-2xl font-semibold text-white">
                            Rp {{ number_format($project->total_paid, 0, ',', '.') }}
                            <span class="text-gray-400 text-sm">/ Rp {{ number_format($project->price, 0, ',', '.') }}</span>
                        </p>
                    </div>
                    <p class="text-sm {{ $project->payment_progress == 100 ? 'text-green-500' : 'text-blue-500' }}">
                        {{ number_format($project->payment_progress, 1) }}%
                    </p>
                </div>
                <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full {{ $project->payment_progress == 100 ? 'bg-green-500' : 'bg-blue-500' }} transition-all duration-500"
                         style="width: {{ $project->payment_progress }}%"></div>
                </div>
            </div>

            <!-- Project Notes -->
            @if($project->notes)
            <div class="mt-6 p-4 bg-gray-800/50 rounded-lg">
                <p class="text-gray-300">{{ $project->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Payments Section -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-white">Payment History</h3>
                <a href="{{ route('admin.projects.payments.create', $project) }}"
                   class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="ri-add-line mr-1"></i> Add Payment
                </a>
            </div>

            @if($payments->count() > 0)
            <div class="space-y-4">
                @foreach($payments as $payment)
                <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg">
                    <div>
                        <p class="font-medium text-white">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-400">
                            {{ $payment->payment_method }} • {{ $payment->payment_date->format('d M Y') }}
                        </p>
                        @if($payment->notes)
                        <p class="text-sm text-gray-500 mt-1">{{ $payment->notes }}</p>
                        @endif
                    </div>
                    <form action="{{ route('admin.projects.payments.destroy', [$project, $payment]) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this payment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <i class="ri-money-dollar-circle-line text-4xl mb-2"></i>
                <p>No payments recorded yet</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 