<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
        </svg>
        {{ $titulo }}
    </h3>
    
    <form action="{{ $action }}" method="{{ $method ?? 'GET' }}" class="space-y-4">
        {{ $slot }}
    </form>
</div>
