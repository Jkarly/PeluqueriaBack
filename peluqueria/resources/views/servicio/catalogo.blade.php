@extends('layouts.plantilla')

@section('title', 'Catálogo de Servicios')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header con búsqueda y filtros -->
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <!-- Columna izquierda: Categorías -->
        <div class="w-full md:w-1/4">
            <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2 flex items-center">
                    <i class="fas fa-list-alt mr-2" style="color: #EE6983;"></i>
                    Categorías
                </h2>
                <ul class="space-y-2">
                    @foreach($categorias as $categoria)
                        <li>
                            <a href="{{ route('servicio.catalogo', ['categoria' => $categoria->id]) }}" 
                               class="flex justify-between items-center text-gray-700 hover:text-[#EE6983] transition-colors {{ (isset($categoriaId) && $categoriaId == $categoria->id) ? 'font-semibold text-[#EE6983]' : '' }}">
                                <span class="flex items-center">
                                    <i class="fas fa-chevron-right mr-2 text-xs text-gray-400"></i>
                                    {{ $categoria->nombre }}
                                </span>
                                <span class="bg-[#FFD3D5] text-[#92487A] text-xs px-2 py-1 rounded-full">
                                    {{ $categoria->servicios_count ?? '' }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                
                <!-- Filtro de precio -->
                <div class="mt-6 pt-4 border-t">
                    <h3 class="text-md font-semibold mb-3 text-gray-800 flex items-center">
                        <i class="fas fa-sort-amount-down mr-2" style="color: #EE6983;"></i>
                        Ordenar por precio
                    </h3>
                    <div class="space-y-2">
                        <a href="{{ route('servicio.catalogo', array_merge(request()->query(), ['orden' => 'desc'])) }}" 
                           class="flex items-center text-sm text-gray-700 hover:text-[#EE6983] transition-colors {{ (request('orden') == 'desc') ? 'font-medium text-[#EE6983]' : '' }}">
                            <i class="fas fa-arrow-down mr-2 text-xs"></i>
                            De mayor a menor precio
                        </a>
                        <a href="{{ route('servicio.catalogo', array_merge(request()->query(), ['orden' => 'asc'])) }}" 
                           class="flex items-center text-sm text-gray-700 hover:text-[#EE6983] transition-colors {{ (request('orden') == 'asc') ? 'font-medium text-[#EE6983]' : '' }}">
                            <i class="fas fa-arrow-up mr-2 text-xs"></i>
                            De menor a mayor precio
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Columna derecha: Contenido principal -->
        <div class="w-full md:w-3/4">
            <!-- Barra de búsqueda y filtros -->
            <div class="bg-white rounded-lg shadow p-4 mb-6 border border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4 items-center">
                    <div class="flex-1 w-full">
                        <form action="{{ route('servicio.catalogo') }}" method="GET" class="flex gap-2">
                            <div class="relative flex-1">
                                <input type="text" name="search" placeholder="Buscar servicio..." value="{{ $search ?? '' }}"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#E49BA6] focus:border-[#E49BA6]">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            <button type="submit" class="bg-[#EE6983] text-white px-6 py-2 rounded-lg hover:bg-[#92487A] transition-colors font-medium flex items-center">
                                <i class="fas fa-search mr-2"></i>
                                Buscar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Grid de servicios -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse ($servicios as $servicio)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 border border-gray-100 group">
                        <!-- Imagen del servicio -->
                        <div class="relative overflow-hidden">
                            @if($servicio->imagen)
                                <img src="{{ asset('storage/images/servicio/' . $servicio->imagen) }}" 
                                    alt="{{ $servicio->nombre }}" 
                                    class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="h-56 w-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center text-gray-300">
                                    <i class="fas fa-spa text-5xl"></i>
                                </div>
                            @endif
                            
                            <!-- Overlay gradiente -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Badge de estado -->
                            <div class="absolute top-3 right-3">
                                @if($servicio->estado)
                                    <span class="bg-green-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full flex items-center shadow-lg">
                                        <i class="fas fa-check-circle mr-1.5 text-xs"></i>
                                        DISPONIBLE
                                    </span>
                                @else
                                    <span class="bg-red-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full flex items-center shadow-lg">
                                        <i class="fas fa-times-circle mr-1.5 text-xs"></i>
                                        NO DISPONIBLE
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Badge de categoría -->
                            <div class="absolute top-3 left-3">
                                <span class="bg-[#92487A] text-white text-xs font-medium px-3 py-1.5 rounded-full flex items-center shadow-lg backdrop-blur-sm">
                                    <i class="fas fa-tag mr-1.5 text-xs"></i>
                                    {{ $servicio->categoria->nombre ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Contenido de la tarjeta -->
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-3 line-clamp-1 group-hover:text-[#92487A] transition-colors duration-300">
                                {{ $servicio->nombre }}
                            </h2>
                            
                            @if($servicio->duracionmin)
                                <p class="text-gray-600 mb-3 flex items-center">
                                    <i class="fas fa-clock mr-3 text-lg" style="color: #EE6983;"></i>
                                    <span class="font-medium">Duración: {{ $servicio->duracionmin }} minutos</span>
                                </p>
                            @endif
                            
                            <p class="text-gray-700 mb-4 line-clamp-2 leading-relaxed">
                                {{ Str::limit($servicio->descripcion ?? 'Descripción no disponible', 90) }}
                            </p>
                            
                            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-500 font-medium">Precio</span>
                                    <p class="text-2xl font-bold" style="color: #92487A;">Bs {{ number_format($servicio->precio, 2) }}</p>
                                </div>

                                <form action="{{ route('carrito.agregar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="idservicio" value="{{ $servicio->id }}">
                                    <button type="submit"
                                        class="bg-[#EE6983] text-white px-5 py-2.5 rounded-xl text-sm font-semibold 
                                        hover:bg-[#92487A] transition-all duration-300 flex items-center shadow-md 
                                        hover:shadow-lg transform hover:scale-105">
                                        <i class="fas fa-cart-plus mr-2.5"></i>
                                        Añadir
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-[#FFD3D5] to-[#E49BA6] rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-3xl text-white"></i>
                        </div>
                        <h3 class="mt-2 text-2xl font-semibold text-gray-900 mb-3">No se encontraron servicios</h3>
                        <p class="mt-1 text-gray-600 text-lg mb-6">Intenta con otros términos de búsqueda o categorías.</p>
                        <a href="{{ route('servicio.catalogo') }}" class="inline-flex items-center px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:shadow-lg" style="background-color: #EE6983; hover:background-color: #92487A;">
                            <i class="fas fa-redo mr-3"></i>
                            Ver todos los servicios
                        </a>
                    </div>
                @endforelse
            </div>
            
            <!-- Paginación -->
            <div class="mt-8 flex justify-center">
                {{ $servicios->links() }}
            </div>
        </div>
    </div>
</div>

<!-- RESUMEN DEL CARRITO (Sidebar Derecha) -->
<div class="fixed bottom-5 right-5 w-80 bg-white shadow-2xl rounded-2xl border border-gray-200 p-5 z-50">
    
    <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
        <i class="fas fa-shopping-cart mr-2 text-[#EE6983]"></i>
        Mi carrito
    </h3>

    @php
        $carritoServicios = (new \App\Http\Controllers\ServicioController)->carritoResumen();
    @endphp

    @if($carritoServicios->isEmpty())
        <p class="text-gray-500 text-sm">No tienes servicios añadidos.</p>
    @else
        <ul class="space-y-3 max-h-64 overflow-y-auto pr-2">
            @foreach($carritoServicios as $item)
                <li class="flex justify-between items-center border-b pb-2">
                    <div>
                        <p class="font-semibold text-gray-700">{{ $item->nombre }}</p>
                        <span class="text-sm text-[#92487A] font-bold">Bs {{ number_format($item->precio,2) }}</span>
                    </div>

                    <form action="{{ route('carrito.eliminar',$item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-lg">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            <p class="text-right font-bold text-xl text-[#92487A]">
                Total: Bs {{ number_format($carritoServicios->sum('precio'), 2) }}
            </p>

            <a href="{{ route('cita.reservar') }}"
               class="mt-3 w-full bg-[#EE6983] text-white py-2.5 rounded-xl block text-center font-semibold hover:bg-[#92487A] transition">
               Reservar cita
            </a>
        </div>
    @endif

</div>

@endsection
