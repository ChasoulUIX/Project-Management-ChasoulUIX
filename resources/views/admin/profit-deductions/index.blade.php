@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
        <h2 class="text-2xl font-semibold">Profit Deductions</h2>
        <a href="{{ route('admin.profit-deductions.create') }}" 
           class="w-full sm:w-auto px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-center">
            <i class="ri-add-line mr-1"></i> Add Deduction
        </a>
    </div>

    <!-- Summary Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-dark-secondary rounded-2xl border border-gray-700/50 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400">Total Deductions</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalDeductions, 0, ',', '.') }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-red-500/10 flex items-center justify-center">
                    <i class="ri-subtract-line text-red-500 text-xl"></i>
                </div>
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
                    <tr class="hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $deduction->deduction_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($deduction->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $deduction->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <form action="{{ route('admin.profit-deductions.destroy', $deduction) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-red-500 hover:text-red-600 transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this deduction?')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400">No deductions recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 