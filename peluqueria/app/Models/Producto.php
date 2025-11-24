<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'stock',
        'preciounitario',
        'costo',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'preciounitario' => 'float',
        'costo' => 'float',
        'stock' => 'integer',
    ];

    // Scope para productos activos
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    // Verificar si hay stock disponible
    public function tieneStock($cantidad = 1)
    {
        return $this->stock >= $cantidad;
    }

    // Calcular ganancia
    public function getGananciaAttribute()
    {
        if ($this->costo) {
            return $this->preciounitario - $this->costo;
        }
        return $this->preciounitario;
    }

    // Calcular margen de ganancia en porcentaje
    public function getMargenGananciaAttribute()
    {
        if ($this->costo && $this->costo > 0) {
            return (($this->preciounitario - $this->costo) / $this->costo) * 100;
        }
        return 0;
    }
    public function productosUtilizados()
    {
        return $this->hasMany(ProductoUtilizado::class, 'idproducto');
    }
}