{{-- resources/views/components/boton_editar.blade.php --}}
@props(['url', 'texto' => 'Editar'])

<a href="{{ $url }}"
    class="inline-flex items-center space-x-1 px-3 py-1 
          bg-blue-600 text-white text-sm font-medium rounded-lg 
          hover:bg-blue-700 transition duration-150 shadow-sm 
          focus:outline-none focus:ring-2 focus:ring-blue-500">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
        stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
    </svg>

    <span>{{ $texto }}</span>
</a>