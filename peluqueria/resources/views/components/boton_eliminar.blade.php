<form action="{{ $url }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este teléfono?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm ml-2">
        - Eliminar
    </button>
</form>