<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DetalleCitaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioAuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ServicioController;

// Route::get('/', function () {
//     return view('welcome');
// });

// // Login personalizado
// Route::get('/login', [UsuarioAuthController::class, 'loginForm'])->name('login');
// // Ruta para procesar login (POST)
// Route::post('/login', [UsuarioAuthController::class, 'login'])->name('usuario.login.post');
// Route::post('/logout', [UsuarioAuthController::class, 'logout'])->name('logout');



// // Rutas protegidas por middleware 'auth'
// Route::middleware('auth')->group(function () {
//     // Home
//     Route::get('/', HomeController::class)->name('home');

//     //Persona
//     Route::get('/persona', [PersonaController::class, 'index'])->name('persona.index'); // Listado de personas
//     Route::get('/persona/crear', [PersonaController::class, 'crear'])->name('persona.crear'); // Formulario de creación
//     Route::post('/persona', [PersonaController::class, 'guardar'])->name('persona.guardar'); // Almacena el nuevo persona
//     Route::get('/persona/{id}/editar', [PersonaController::class, 'editar'])->name('persona.editar'); // Formulario de edición
//     Route::put('/persona/{id}', [PersonaController::class, 'actualizar'])->name('persona.actualizar'); // Actualiza el persona
    
//     // Rol
//     Route::get('/rol', [RolController::class, 'index'])->name('rol.index'); // Listado de roles
//     Route::get('/rol/crear', [RolController::class, 'crear'])->name('rol.crear'); // Formulario de creación
//     Route::post('/rol', [RolController::class, 'guardar'])->name('rol.guardar'); // Almacena el nuevo rol
//     Route::get('/rol/{id}/editar', [RolController::class, 'editar'])->name('rol.editar'); // Formulario de edición
//     Route::put('/rol/{id}', [RolController::class, 'actualizar'])->name('rol.actualizar'); // Actualiza el rol


//     //Usuario
//     Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario.index');
//     Route::get('/usuario/crear', [UsuarioController::class, 'crear'])->name('usuario.crear');
//     Route::post('/usuario', [UsuarioController::class, 'guardar'])->name('usuario.guardar');
//     Route::get('/usuario/{id}/edit', [UsuarioController::class, 'editar'])->name('usuario.editar');
//     Route::put('/usuario/{id}', [UsuarioController::class, 'actualizar'])->name('usuario.actualizar');
//     //Categoria
//     Route::get('/categoria', [CategoriaController::class, 'index'])->name('categoria.index');
//     Route::get('/categoria/crear', [CategoriaController::class, 'crear'])->name('categoria.crear');
//     Route::post('/categoria', [CategoriaController::class, 'guardar'])->name('categoria.guardar');
//     Route::get('/categoria/{id}/editar', [CategoriaController::class, 'editar'])->name('categoria.editar');
//     Route::put('/categoria/{id}', [CategoriaController::class, 'actualizar'])->name('categoria.actualizar');
//     //Servicio
//     Route::get('/servicio', [ServicioController::class, 'index'])->name('servicio.index');
//     Route::get('/servicio/crear', [ServicioController::class, 'crear'])->name('servicio.crear');
//     Route::post('/servicio', [ServicioController::class, 'guardar'])->name('servicio.guardar');
//     Route::get('/servicio/{id}/editar', [ServicioController::class, 'editar'])->name('servicio.editar');
//     Route::put('/servicio/{id}', [ServicioController::class, 'actualizar'])->name('servicio.actualizar');
//     Route::get('/catalogo', [ServicioController::class, 'catalogo'])->name('servicio.catalogo');
//     Route::post('/carrito/agregar', [ServicioController::class, 'carritoAgregar'])->name('carrito.agregar');
//     Route::get('/carrito', [ServicioController::class, 'carritoVer'])->name('carrito.ver');
//     Route::delete('/carrito/eliminar/{id}', [ServicioController::class, 'carritoEliminar'])->name('carrito.eliminar');

    
//     //Cita
//     Route::get('/citas', [CitaController::class, 'index'])->name('cita.index');
//     Route::get('/citas/reservar', [CitaController::class, 'reservar'])->name('cita.reservar');
//     Route::post('/citas/guardar', [CitaController::class, 'guardar'])->name('cita.guardar');
//     Route::get('/citas/editar/{id}', [CitaController::class, 'editar'])->name('cita.editar');
//     Route::post('/citas/actualizar/{id}', [CitaController::class, 'actualizar'])->name('cita.actualizar');
    
//     //DetalleCita
//     Route::prefix('detallecita')->group(function () {
//         Route::get('/', [DetalleCitaController::class, 'index'])->name('detallecita.index');
//         Route::get('/crear', [DetalleCitaController::class, 'crear'])->name('detallecita.crear');
//         Route::post('/guardar', [DetalleCitaController::class, 'guardar'])->name('detallecita.guardar');
//         Route::get('/editar/{id}', [DetalleCitaController::class, 'editar'])->name('detallecita.editar');
//         Route::post('/actualizar/{id}', [DetalleCitaController::class, 'actualizar'])->name('detallecita.actualizar');
//     });
//     Route::get('/historialcitas', [DetalleCitaController::class, 'historialCliente'])->middleware('auth')->name('detallecita.historial');
//     //Rol
//     Route::get('/rol', [RolController::class, 'index'])->name('rol.index');
//     Route::get('/rol/crear', [RolController::class, 'crear'])->name('rol.crear');
//     Route::post('/rol', [RolController::class, 'guardar'])->name('rol.guardar');
//     Route::get('/rol/{id}/editar', [RolController::class, 'editar'])->name('rol.editar');
//     Route::put('/rol/{id}', [RolController::class, 'actualizar'])->name('rol.actualizar');
//     // Logout
//     Route::post('/logout', [UsuarioAuthController::class, 'logout'])->name('logout');
// });
