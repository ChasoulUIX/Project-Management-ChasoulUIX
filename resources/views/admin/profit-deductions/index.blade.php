@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
        <div>
            <h2 class="text-2xl font-semibold">Profit Deductions</h2>
            <p class="text-gray-400 mt-1">Manage and track your profit deductions</p>
        </div>
        <a href="{{ route('admin.profit-deductions.create') }}" 
           class="w-full sm:w-auto px-4 py-2.5 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-colors text-center inline-flex items-center justify-center gap-2">
            <i class="ri-add-line"></i>
            Add Deduction
        </a>
    </div>

    <!-- Summary Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6 hover:border-red-500/50 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400">Total Deductions</p>
                    <h3 class="text-2xl font-bold mt-1">Rp {{ number_format($totalDeductions, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center">
                    <i class="ri-subtract-line text-red-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-red-500">
                <i class="ri-money-dollar-circle-line"></i>
                <span class="text-sm">Total amount deducted from profits</span>
            </div>
        </div>
    </div>

    <!-- Deductions Table -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700/50">
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-400">Date</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-400">Amount</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-gray-400">Description</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($deductions as $deduction)
                    <tr class="hover:bg-gray-800/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center">
                                    <i class="ri-subtract-line text-red-500"></i>
                                </div>
                                <span>{{ $deduction->deduction_date->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">Rp {{ number_format($deduction->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $deduction->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <form action="{{ route('admin.profit-deductions.destroy', $deduction) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-gray-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100"
                                        onclick="return confirm('Are you sure you want to delete this deduction?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <div class="w-12 h-12 rounded-xl bg-gray-800/50 flex items-center justify-center mb-2">
                                    <i class="ri-subtract-line text-xl"></i>
                                </div>
                                <p>No deductions recorded yet.</p>
                                <a href="{{ route('admin.profit-deductions.create') }}" 
                                   class="text-blue-500 hover:text-blue-400 inline-flex items-center gap-1 mt-2">
                                    <i class="ri-add-line"></i>
                                    Add your first deduction
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 