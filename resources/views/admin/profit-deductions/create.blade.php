@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold">Add Profit Deduction</h2>
        <a href="{{ route('admin.profit-deductions.index') }}" 
           class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
            <i class="ri-arrow-left-line mr-1"></i> Back
        </a>
    </div>

    <!-- Form -->
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <form action="{{ route('admin.profit-deductions.store') }}" method="POST" class="p-6" id="deductionForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Amount -->
                <div class="space-y-2">
                    <label for="display_amount" class="block text-sm font-medium text-gray-400">Amount</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">Rp</span>
                        <input type="text" 
                               id="display_amount" 
                               class="w-full pl-10 pr-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('amount') }}"
                               required>
                        <input type="hidden" 
                               name="amount" 
                               id="amount" 
                               value="{{ old('amount') }}">
                    </div>
                    @error('amount')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deduction Date -->
                <div class="space-y-2">
                    <label for="deduction_date" class="block text-sm font-medium text-gray-400">Deduction Date</label>
                    <input type="date" 
                           name="deduction_date" 
                           id="deduction_date" 
                           value="{{ old('deduction_date', date('Y-m-d')) }}"
                           class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('deduction_date')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="space-y-2 md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-400">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" 
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="ri-save-line mr-1"></i> Save Deduction
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const displayAmount = document.getElementById('display_amount');
    const amount = document.getElementById('amount');
    const form = document.getElementById('deductionForm');

    // Format initial value if exists
    if (displayAmount.value) {
        const initialValue = parseFloat(displayAmount.value.replace(/\./g, ''));
        if (!isNaN(initialValue)) {
            displayAmount.value = formatNumber(initialValue);
        }
    }

    displayAmount.addEventListener('input', function(e) {
        // Remove non-numeric characters
        let value = this.value.replace(/\D/g, '');
        
        // Convert to number
        const numericValue = parseInt(value) || 0;
        
        // Format with thousand separators
        this.value = formatNumber(numericValue);
        
        // Update hidden input with actual numeric value
        amount.value = numericValue;
    });

    form.addEventListener('submit', function(e) {
        // Ensure the amount field has a value
        if (!amount.value) {
            e.preventDefault();
            alert('Please enter a valid amount');
        }
    });

    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
});
</script>
@endsection 