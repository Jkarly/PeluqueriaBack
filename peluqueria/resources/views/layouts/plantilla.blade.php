<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', 'Mi sitio Web')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1B3C53',
                        secondary: '#456882',
                        accent: '#D2C1B6',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    
    <header>
        <x-navbar />
    </header>

    <main class="flex-grow w-full">
        @yield('content')
    </main>

    <footer class="bg-purple-900 text-white">
        <div class="py-4">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="w-24 mb-2 md:mb-0">
                    
                    <p class="text-sm opacity-80">&copy; {{ date('Y') }} Mi Sitio Web. Todos los derechos reservados.</p>
                    
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-sm opacity-80 hover:text-white hover:opacity-100 transition duration-300">Política de Privacidad</a>
                        <a href="#" class="text-sm opacity-80 hover:text-white hover:opacity-100 transition duration-300">Términos de Servicio</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('scripts')

     @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Oops!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#EE6983'
        });
    </script>
    @endif

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#92487A'
        });
    </script>
    @endif
</body>
</html>