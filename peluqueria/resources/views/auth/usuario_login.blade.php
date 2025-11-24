@extends('layouts.plantilla')

@section('title', 'Inicio de Sesión')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#2A1458] to-[#1A0C3A] flex items-center justify-center p-4">
    <div class="w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row transform transition-all duration-300 hover:shadow-3xl">
        <!--  imagen -->
        <div class="hidden md:block md:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-[#2A1458]/80 to-transparent z-10"></div>
            <img src="{{ asset('storage/login.jpeg') }}" alt="Login Image" 
                class="w-full h-full object-cover transform hover:scale-105 transition duration-700">
            <div class="absolute bottom-8 left-8 z-20 text-white">
                <h2 class="text-2xl font-bold mb-2">FISCALÍA DEPARTAMENTAL</h2>
                <p class="text-lg">Sistema de Gestión Institucional</p>
            </div>
        </div>

        <!-- formulario -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-10">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#2A1458]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Iniciar Sesión</h1>
                    <p class="text-gray-500">Ingresa tus credenciales para acceder al sistema</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg text-sm flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <strong class="font-medium">Error!</strong>
                            <ul class="list-disc list-inside mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('usuario.login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="space-y-1">
                        <label for="correo" class="block text-sm font-medium text-gray-700">Usuario</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" name="correo" id="correo" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2A1458] focus:border-[#2A1458] outline-none transition duration-200"
                                placeholder="usuario@fiscalia.gob.bo"
                                value="{{ old('correo') }}">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="contrasena" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" name="contrasena" id="contrasena" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2A1458] focus:border-[#2A1458] outline-none transition duration-200"
                                placeholder="••••••••">
                        </div>
                        <div class="flex justify-end mt-1">
                            <a href="#" class="text-sm text-[#2A1458] hover:underline">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-[#2A1458] to-[#4A23A8] hover:from-[#3A1D78] hover:to-[#5A2BC8] text-white font-medium py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>¿Problemas para ingresar? <a href="#" class="text-[#2A1458] font-medium hover:underline">Contacta al administrador</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection