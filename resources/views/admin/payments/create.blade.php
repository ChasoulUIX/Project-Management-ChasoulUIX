@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold text-white">Add Payment</h2>
            <p class="text-gray-400 mt-1">Record new payment for {{ $project->name }}</p>
        </div>

        <form action="{{ route('admin.projects.payments.store', $project) }}" method="POST" class="p-6 space-y-6" onsubmit="return validateForm()">
            @csrf

            <!-- Amount -->
            <div class="space-y-2">
                <label for="display_amount" class="block text-sm font-medium text-gray-300">
                    Amount (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500">Rp</span>
                    <input type="text" 
                           id="display_amount" 
                           value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}"
                           class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100 placeholder-gray-500"
                           placeholder="10.000"
                           oninput="formatAmount(this)">
                    <input type="hidden" name="amount" id="real_amount" value="{{ old('amount') }}">
                </div>
                @error('amount')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Method -->
            <div class="space-y-2">
                <label for="payment_method" class="block text-sm font-medium text-gray-300">
                    Payment Method <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="payment_method" 
                       id="payment_method" 
                       value="{{ old('payment_method') }}"
                       class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                              text-gray-100 placeholder-gray-500"
                       placeholder="e.g., Bank Transfer, Cash">
                @error('payment_method')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Date -->
            <div class="space-y-2">
                <label for="payment_date" class="block text-sm font-medium text-gray-300">
                    Payment Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="payment_date" 
                       id="payment_date" 
                       value="{{ old('payment_date', date('Y-m-d')) }}"
                       class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                              focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                              text-gray-100">
                @error('payment_date')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="space-y-2">
                <label for="notes" class="block text-sm font-medium text-gray-300">Notes</label>
                <textarea name="notes" 
                          id="notes" 
                          rows="3"
                          class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                                 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                 text-gray-100 placeholder-gray-500"
                          placeholder="Any additional notes">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.projects.show', $project) }}" 
                   class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Save Payment
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function formatAmount(input) {
    // Hapus semua karakter selain angka
    let rawValue = input.value.replace(/\D/g, '');
    
    // Update nilai sebenarnya untuk dikirim ke server (SEBELUM format)
    document.getElementById('real_amount').value = rawValue;
    
    // Format dengan pemisah ribuan untuk tampilan
    let formattedValue = new Intl.NumberFormat('id-ID').format(rawValue);
    
    // Update tampilan input
    input.value = formattedValue;
}

function validateForm() {
    // Pastikan hidden input terisi sebelum submit
    const displayAmount = document.getElementById('display_amount');
    const realAmount = document.getElementById('real_amount');
    
    // Update real_amount dari display_amount sebelum submit
    if (displayAmount.value) {
        realAmount.value = displayAmount.value.replace(/\D/g, '');
    }
    
    // Validasi amount tidak boleh kosong
    if (!realAmount.value || realAmount.value === '0') {
        alert('Please enter a valid amount');
        return false;
    }
    
    return true;
}

// Format initial value if exists
document.addEventListener('DOMContentLoaded', function() {
    const displayAmount = document.getElementById('display_amount');
    if (displayAmount.value) {
        formatAmount(displayAmount);
    }
});
</script>
@endpush
@endsection 