@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center relative overflow-hidden px-4 py-6">
    <!-- Background Elements - Perbaikan untuk mobile -->
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-2xl md:blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500/5 rounded-full blur-2xl md:blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Header -->
        <div class="text-center space-y-6 mb-8">
            <div class="relative inline-block">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-3xl blur md:blur-xl"></div>
                <div class="relative inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-dark-secondary border border-gray-700/50 rounded-3xl shadow-lg">
                    <i class="ri-whatsapp-line text-4xl md:text-5xl bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent"></i>
                </div>
            </div>
            <div class="space-y-2">
                <h2 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">
                   ChasoulUIX
                </h2>
                <p class="text-gray-400 text-sm md:text-base">Masukan Nomor WhatsApp Anda untuk melihat detail proyek</p>
            </div>
        </div>

        <!-- Search Form - Perbaikan untuk mobile -->
        <div class="bg-dark-secondary/95 md:bg-dark-secondary/80 rounded-2xl md:rounded-3xl border border-gray-700/50 p-6 md:p-8 shadow-xl">
            <form action="{{ route('users.projects.search') }}" method="GET" class="space-y-5 md:space-y-6">
                <div>
                    <label for="whatsapp" class="block text-sm font-medium text-gray-400 mb-2">
                        WhatsApp Number
                    </label>
                    <div class="relative group">
                        <!-- Mengurangi blur effect di mobile -->
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-xl blur-sm md:blur transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                            <i class="ri-whatsapp-line text-gray-500 group-hover:text-blue-500 transition-colors"></i>
                        </div>
                        <input type="text" 
                               id="whatsapp"
                               name="whatsapp" 
                               value="{{ old('whatsapp') }}"
                               placeholder="Example: 085172360309" 
                               class="w-full bg-dark-primary border border-gray-700/50 rounded-xl pl-11 pr-4 py-3 md:py-3.5 focus:outline-none focus:border-blue-500/50 transition-all duration-300 text-gray-300 relative z-10"
                               inputmode="numeric"
                               pattern="[0-9]*"
                        >
                    </div>
                    @error('whatsapp')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full relative group">
                    <!-- Mengurangi blur effect di mobile -->
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl blur-sm md:blur transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                    <div class="relative bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-xl px-4 py-3 md:py-3.5 flex items-center justify-center gap-2 font-medium transition-all duration-300 group-hover:shadow-lg group-hover:shadow-blue-500/25">
                        <i class="ri-search-line text-lg"></i>
                        <span>Check Projects</span>
                    </div>
                </button>
            </form>

            <!-- Quick Tips -->
            <div class="mt-5 pt-5 md:mt-6 md:pt-6 border-t border-gray-700/50">
                <div class="flex items-start gap-3 text-xs md:text-sm text-gray-400">
                    <i class="ri-information-line mt-0.5"></i>
                    <p>Gunakan Nomor Whatsapp yang berkomunikasi dengan ChasoulUIX</p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Animasi yang lebih ringan untuk mobile */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.4s ease-out;
}

/* Optimasi untuk perangkat dengan reduced motion */
@media (prefers-reduced-motion: reduce) {
    .animate-fadeInUp {
        animation: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan class hanya jika tidak dalam mode reduced motion
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.querySelector('.max-w-md').classList.add('animate-fadeInUp');
    }
});
</script>
@endsection 