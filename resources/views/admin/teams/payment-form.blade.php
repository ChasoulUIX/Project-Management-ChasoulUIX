@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-dark-secondary rounded-2xl border border-gray-700/50">
        <div class="p-6 border-b border-gray-700/50">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Record Payment for {{ $team->name }}</h2>
                <a href="{{ route('admin.teams.show', $team) }}" 
                   class="text-gray-400 hover:text-gray-300 transition-colors">
                    <i class="ri-close-line text-xl"></i>
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Payment Progress -->
            <div class="bg-dark-primary rounded-lg p-4 mb-6">
                <div class="flex justify-between items-end mb-2">
                    <div>
                        <p class="text-sm text-gray-400">Payment Progress</p>
                        <p class="text-xl font-semibold mt-1">
                            <span class="text-white">Rp {{ number_format($project->pivot->amount_paid ?? 0, 0, ',', '.') }}</span>
                            <span class="text-gray-400 text-sm">/ Rp {{ number_format($project->pivot->salary, 0, ',', '.') }}</span>
                        </p>
                    </div>
                    <p class="text-sm {{ ($project->pivot->amount_paid ?? 0) >= $project->pivot->salary ? 'text-green-500' : 'text-blue-500' }}">
                        {{ number_format((($project->pivot->amount_paid ?? 0) / $project->pivot->salary) * 100, 1) }}%
                    </p>
                </div>
                <div class="h-2 bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full {{ ($project->pivot->amount_paid ?? 0) >= $project->pivot->salary ? 'bg-green-500' : 'bg-blue-500' }} transition-all duration-500"
                         style="width: {{ (($project->pivot->amount_paid ?? 0) / $project->pivot->salary) * 100 }}%">
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.teams.record-payment', ['team' => $team, 'project' => $project]) }}" 
                  method="POST" 
                  class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Project</label>
                    <p class="text-gray-400">{{ $project->name }}</p>
                </div>

                <div class="space-y-2">
                    <label for="amount" class="block text-sm font-medium text-gray-300">Payment Amount</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">Rp</span>
                        <input type="text" 
                               name="display_amount" 
                               id="display_amount"
                               value="{{ old('display_amount') }}"
                               class="w-full pl-12 pr-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                      text-gray-100 placeholder-gray-500"
                               placeholder="0"
                               oninput="formatAmount(this)"
                               required>
                        <input type="hidden" name="amount" id="amount">
                    </div>
                    @error('amount')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="payment_date" class="block text-sm font-medium text-gray-300">Payment Date</label>
                    <input type="date" 
                           name="payment_date" 
                           id="payment_date"
                           value="{{ old('payment_date', date('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 bg-dark-primary border border-gray-700 rounded-lg 
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                  text-gray-100"
                           required>
                    @error('payment_date')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

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

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('admin.teams.show', $team) }}" 
                       class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Record Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function formatAmount(input) {
    // Remove all non-digit characters
    let value = input.value.replace(/\D/g, '');
    
    // Convert to number to remove leading zeros
    value = parseInt(value) || 0;
    
    // Format with thousand separator for display
    input.value = new Intl.NumberFormat('id-ID').format(value);
    
    // Set the actual value to be sent to server
    document.getElementById('amount').value = value;
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