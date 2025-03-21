@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <h2 class="text-2xl font-semibold text-white">Add Payment</h2>
            <p class="text-gray-400 mt-1">Record new payment for {{ $project->name }}</p>
        </div>

        <form action="{{ route('admin.projects.payments.store', $project) }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Amount -->
            <div class="space-y-2">
                <label for="amount" class="block text-sm font-medium text-gray-300">
                    Amount (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-2.5 text-gray-500">Rp</span>
                    <input type="number" 
                           name="amount" 
                           id="amount" 
                           value="{{ old('amount') }}"
                           class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100 placeholder-gray-500"
                           placeholder="0">
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
@endsection 