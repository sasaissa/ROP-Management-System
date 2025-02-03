@props(['text'])

<div x-data="{ show: false }" 
     @mouseenter="show = true" 
     @mouseleave="show = false" 
     class="relative inline-flex">
    
    <div class="inline-flex items-center">
        {{ $slot }}
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-4 w-4 ml-1 text-gray-400" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 16v-4" />
            <path d="M12 8h.01" />
        </svg>
    </div>

    <div x-show="show"
         x-transition:enter="transition-all duration-200 ease-out"
         x-transition:enter-start="opacity-0 translate-x-2"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition-all duration-200 ease-in"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-2"
         class="absolute z-50 left-full ml-2 top-1/2 -translate-y-1/2 px-3 py-2 text-sm bg-white rounded-md border border-gray-200 shadow w-64"
         style="display: none;">
        <div class="relative">
            <h3 class="font-semibold text-gray-900">{{ $slot }}</h3>
            <p class="text-gray-600 mt-1">{{ $text }}</p>
            <div class="absolute top-1/2 -translate-y-1/2 -left-2 border-[6px] border-transparent border-r-white"></div>
        </div>
    </div>
</div>