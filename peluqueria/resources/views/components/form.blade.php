@props([
    'action',
    'method' => 'POST',
    'enctype' => 'application/x-www-form-urlencoded',
    'submitText' => 'Continue',
    'formTitle' => null,
    'width' => 'max-w-2xl',
    'logoSrc' => asset('storage/logo.png'),
    'disabled' => false,
    'submitLoading' => false,
    'cancelUrl' => 'javascript:history.back()',
])

{{-- Contenedor externo --}}
<div class="mx-auto {{ $width }} mt-16 mb-24 p-1 rounded-2xl shadow-lg">
    {{-- Fondo blanco --}}
    <div class="relative rounded-2xl overflow-hidden bg-white z-0">
        <div class="relative flex flex-col items-center justify-center h-full p-8 rounded-2xl shadow-md z-10">

            {{-- Logo --}}
            @if ($logoSrc)
                <img src="{{ $logoSrc }}" alt="Logo" class="mb-6 w-24 h-auto" />
            @endif

            {{-- Título opcional --}}
            @if ($formTitle)
                <h2 class="mb-6 text-xl font-bold text-gray-800">{{ $formTitle }}</h2>
            @endif

            {{-- Formulario --}}
            <form action="{{ $action }}" method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}"
                enctype="{{ $enctype }}" class="w-full space-y-6"
                @if ($disabled) aria-disabled="true" @endif>

                @csrf
                @if (!in_array(strtoupper($method), ['GET', 'POST']))
                    @method($method)
                @endif

                <div class="space-y-6">
                    {{ $slot }}
                </div>

                {{-- Botones --}}
                <div class="mt-8 flex justify-between gap-4">
                    {{-- Botón de envío - Reducido padding --}}
                    <button type="submit"
                        class="w-1/2 px-4 py-2 font-semibold text-white bg-emerald-500 hover:bg-emerald-600 rounded-xl transition"
                        @if ($disabled || $submitLoading) disabled @endif>
                        {{ $submitLoading ? 'Cargando...' : $submitText }}
                    </button>

                    {{-- Botón Cancelar - Reducido padding --}}
                    <a href="{{ $cancelUrl }}"
                        class="w-1/2 text-center px-4 py-2 font-semibold text-white bg-purple-900 rounded-xl hover:bg-purple-800 transition">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>