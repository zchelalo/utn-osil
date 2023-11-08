<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class congresos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'img',
        'numero_vistas',
        'activo',
        'id_organizacion',
    ];

    protected $casts = [
        'img' => 'array', // Convierte la columna 'direccion' en un arreglo asociativo
    ];

    public function organizaciones()
    {
        return $this->belongsTo(organizaciones::class, 'id_organizacion');
    }
}
