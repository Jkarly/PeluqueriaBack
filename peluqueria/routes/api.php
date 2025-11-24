<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioAuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DetalleCitaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpleadoEspecialidadController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ProductoUtilizadoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TelegramReminderController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilService;

// Rutas Públicas
Route::post('/login', [UsuarioAuthController::class, 'login']);
Route::post('/logout', [UsuarioAuthController::class, 'logout']);
Route::post('/register', [ClienteAuthController::class, 'register']);
Route::post('/check-email', [ClienteAuthController::class, 'checkEmail']);

// Rutas de Catálogo y Carrito (públicas)
Route::get('/servicios/catalogo', [ServicioController::class, 'catalogo']);
Route::post('/carrito/agregar', [ServicioController::class, 'carritoAgregar']);
Route::get('/carrito', [ServicioController::class, 'carritoVer']);
Route::delete('/carrito/{id}', [ServicioController::class, 'carritoEliminar']);
Route::get('/carrito/resumen', [ServicioController::class, 'carritoResumen']);
Route::post('/carrito/sincronizar', [ServicioController::class, 'carritoSincronizar']); // NUEVA
Route::get('/carrito/estado', [ServicioController::class, 'carritoEstado']); // NUEVA

// Rutas Protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UsuarioAuthController::class, 'logout']);
    Route::get('/user', [UsuarioAuthController::class, 'user']);
    
    // Categorías
    Route::get('/categorias', [CategoriaController::class, 'index']);
    Route::post('/categorias', [CategoriaController::class, 'guardar']);
    Route::get('/categorias/{id}', [CategoriaController::class, 'mostrar']);
    Route::put('/categorias/{id}', [CategoriaController::class, 'actualizar']);
    Route::delete('/categorias/{id}', [CategoriaController::class, 'eliminar']);

    // Servicios
    Route::get('/servicios/crear', [ServicioController::class, 'crear']);
    Route::get('/servicios', [ServicioController::class, 'index']);
    Route::post('/servicios', [ServicioController::class, 'guardar']);
    Route::get('/servicios/{id}/editar', [ServicioController::class, 'editar']);
    Route::put('/servicios/{id}', [ServicioController::class, 'actualizar']);
    Route::get('/servicios/categorias-con-conteo', [ServicioController::class, 'categoriasConConteo']);

    // Citas
    Route::get('/citas', [CitaController::class, 'index']);
    Route::get('/citas/reservar', [CitaController::class, 'reservar']);
    Route::post('/citas', [CitaController::class, 'guardar']);
    Route::get('/citas/{id}', [CitaController::class, 'editar']);
    Route::put('/citas/{id}', [CitaController::class, 'actualizar']);


    // Detalles de Cita
    Route::get('/detalle-citas', [DetalleCitaController::class, 'index']);
    Route::get('/detalle-citas/filtros', [DetalleCitaController::class, 'filtros']);
    Route::get('/detalle-citas/crear', [DetalleCitaController::class, 'crear']);
    Route::post('/detalle-citas', [DetalleCitaController::class, 'guardar']);
    Route::get('/detalle-citas/{id}/editar', [DetalleCitaController::class, 'editar']);
    Route::put('/detalle-citas/{id}', [DetalleCitaController::class, 'actualizar']);
    Route::delete('/detalle-citas/{id}', [DetalleCitaController::class, 'eliminar']);
    Route::get('/detalle-citas/historial/cliente', [DetalleCitaController::class, 'historialCliente']);


    // Promociones
    Route::get('/promociones', [PromocionController::class, 'index']);
    Route::get('/promociones/crear', [PromocionController::class, 'crear']);
    Route::post('/promociones', [PromocionController::class, 'guardar']);
    Route::get('/promociones/{id}/editar', [PromocionController::class, 'editar']);
    Route::put('/promociones/{id}', [PromocionController::class, 'actualizar']);
    Route::delete('/promociones/{id}', [PromocionController::class, 'eliminar']);
    

    //Producto
    Route::get('/productos', [ProductoController::class, 'index']);
    Route::get('/productos/crear', [ProductoController::class, 'crear']);
    Route::post('/productos', [ProductoController::class, 'guardar']);
    Route::get('/productos/{id}/editar', [ProductoController::class, 'editar']);
    Route::put('/productos/{id}', [ProductoController::class, 'actualizar']);
    Route::delete('/productos/{id}', [ProductoController::class, 'eliminar']);
    Route::get('/productos/{id}', [ProductoController::class, 'mostrar']);


    // Productos utilizados en cita
    Route::get('/productos-utilizados', [ProductoUtilizadoController::class, 'index']);
    Route::get('/productos-utilizados/crear', [ProductoUtilizadoController::class, 'crear']);
    Route::post('/productos-utilizados', [ProductoUtilizadoController::class, 'guardar']);
    Route::get('/productos-utilizados/{id}/editar', [ProductoUtilizadoController::class, 'editar']);
    Route::put('/productos-utilizados/{id}', [ProductoUtilizadoController::class, 'actualizar']);
    Route::delete('/productos-utilizados/{id}', [ProductoUtilizadoController::class, 'eliminar']);

    // Favoritos
    Route::get('/favoritos', [FavoritoController::class, 'index']);
    Route::get('/favoritos/crear', [FavoritoController::class, 'crear']);
    Route::post('/favoritos', [FavoritoController::class, 'guardar']);
    Route::get('/favoritos/{id}/editar', [FavoritoController::class, 'editar']);
    Route::put('/favoritos/{id}', [FavoritoController::class, 'actualizar']);
    Route::delete('/favoritos/{id}', [FavoritoController::class, 'eliminar']);
    Route::get('/mis-favoritos', [FavoritoController::class, 'misFavoritos']);

    //Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::get('/usuarios/crear', [UsuarioController::class, 'crear']);
    Route::post('/usuarios', [UsuarioController::class, 'guardar']);
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editar']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'actualizar']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminar']);
    Route::patch('/usuarios/{id}/cambiar-estado', [UsuarioController::class, 'cambiarEstado']);

    //Reporte
    Route::get('/reportes/ganancia-neta-diaria', [ReporteController::class, 'gananciaNetaPorDia']);
    Route::get('/reportes/ganancia-neta-diaria/pdf', [ReporteController::class, 'gananciaNetaDiariaPdf']);

    //Horarios
    Route::get('/horarios', [HorarioController::class, 'index']);
    Route::get('/horarios/crear', [HorarioController::class, 'crear']);
    Route::post('/horarios', [HorarioController::class, 'guardar']);
    Route::get('/horarios/{id}/editar', [HorarioController::class, 'editar']);
    Route::put('/horarios/{id}', [HorarioController::class, 'actualizar']); 
    
    //Roles
    Route::get('/roles/crear', [RolController::class, 'crear']);        
    Route::get('/roles', [RolController::class, 'index']);
    Route::post('/roles', [RolController::class, 'guardar']);   
    Route::get('/roles/{id}/editar', [RolController::class, 'editar']);
    Route::put('/roles/{id}', [RolController::class, 'actualizar']);

    //Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::get('/usuarios/crear', [UsuarioController::class, 'crear']);
    Route::post('/usuarios', [UsuarioController::class, 'guardar']);
    Route::get('/usuarios/{id}/editar', [UsuarioController::class, 'editar']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'actualizar']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'eliminar']);
    Route::patch('/usuarios/{id}/cambiar-estado', [UsuarioController::class, 'cambiarEstado']);

    // Personas
    Route::get('/personas/crear', [PersonaController::class, 'crear']); 
    Route::get('/personas', [PersonaController::class, 'index']);
    Route::post('/personas', [PersonaController::class, 'guardar']);
    Route::get('/personas/{id}/editar', [PersonaController::class, 'editar']);
    Route::put('/personas/{id}', [PersonaController::class, 'actualizar']);

    // Clientes
    Route::get('/clientes/crear', [ClienteController::class, 'crear']);         
    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::post('/clientes', [ClienteController::class, 'guardar']);    
    Route::get('/clientes/{id}/editar', [ClienteController::class, 'editar']);
    Route::put('/clientes/{id}', [ClienteController::class, 'actualizar']);

    // Empleados
    Route::get('/empleados/crear', [EmpleadoController::class, 'crear']);   
    Route::get('/empleados', [EmpleadoController::class, 'index']);
    Route::post('/empleados', [EmpleadoController::class, 'guardar']);    
    Route::get('/empleados/{id}/editar', [EmpleadoController::class, 'editar']);
    Route::put('/empleados/{id}', [EmpleadoController::class, 'actualizar']);

    // Especialidades
    Route::get('/especialidades/crear', [EspecialidadController::class, 'crear']);   
    Route::get('/especialidades', [EspecialidadController::class, 'index']);    
    Route::post('/especialidades', [EspecialidadController::class, 'guardar']);    
    Route::get('/especialidades/{id}/editar', [EspecialidadController::class, 'editar']);
    Route::put('/especialidades/{id}', [EspecialidadController::class, 'actualizar']);

    //Empleado Especialidades
    Route::get('/empleado-especialidades/crear', [EmpleadoEspecialidadController::class, 'crear']);   
    Route::get('/empleado-especialidades', [EmpleadoEspecialidadController::class, 'index']);    
    Route::post('/empleado-especialidades', [EmpleadoEspecialidadController::class, 'guardar']);
    Route::get('/empleado-especialidades/{id}/editar', [EmpleadoEspecialidadController::class, 'editar']);
    Route::put('/empleado-especialidades/{id}', [EmpleadoEspecialidadController::class, 'actualizar']);    
    //Recordatorio
    Route::post('/citas/{id}/recordatorio-telegram', [TelegramReminderController::class, 'enviarRecordatorioCita']);
    //Perfil
    Route::get('/perfil', [PerfilService::class, 'show']);
    Route::put('/perfil', [PerfilService::class, 'update']); 


});