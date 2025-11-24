<nav style="background-color: #c7e0bff8;" class="shadow-lg">
    <div class="max-w-9xl mx-auto px-8 sm:px-10 lg:px-16">
        <div class="flex items-center justify-between h-20">

            <a href="{{ route('home') }}" class="flex-shrink-0">
                <img src="{{ asset('storage/nanvar.png') }}" alt="Logo Fiscalía" class="h-12 w-auto" />
            </a>

            <div class="flex-grow flex justify-end">
                <div class="hidden md:flex items-center space-x-4">
                    
                    {{-- Rutas Administrativas --}}
                    <a href="{{ route('rol.index') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Roles
                    </a>

                    <a href="{{ route('persona.index') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Personas
                    </a>

                    <a href="{{ route('usuario.index') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Usuarios
                    </a>

                    <a href="{{ route('categoria.index') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Categorías
                    </a>
                    
                    <a href="{{ route('servicio.index') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Servicios (Admin)
                    </a>

                     <a href="{{ route('cita.index') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Citas
                    </a>

                     <a href="{{ route('detallecita.index') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Detalle Citas
                    </a>

                    {{-- Rutas para Clientes --}}
                    <a href="{{ route('servicio.catalogo') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md font-bold">
                        Catálogo de Servicios
                    </a>

                    <a href="{{ route('cita.reservar') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Reservar Cita
                    </a>

                    <a href="{{ route('detallecita.historial') }}"
                        class="text-purple-900 hover:bg-purple-900 hover:text-white px-3 py-2 rounded-md">
                        Historial de Citas
                    </a>

                    {{-- Logout --}}
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="bg-gradient-to-br from-green-600 to-green-800 text-white p-3 rounded-lg shadow-md">
                        Cerrar sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        if (menu) menu.classList.toggle('hidden');
    });
</script>
