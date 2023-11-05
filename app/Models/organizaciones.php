<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organizaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
    ];

    protected $casts = [
        'direccion' => 'array', // Convierte la columna 'direccion' en un arreglo asociativo
    ];
}
