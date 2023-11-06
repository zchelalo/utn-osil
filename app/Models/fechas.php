<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fechas extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'inicio',
        'fin',
        'id_presentacion',
        'id_congreso',
    ];

    public function congresos()
    {
        return $this->belongsTo(congresos::class, 'id_congreso');
    }

    public function presentaciones()
    {
        return $this->belongsTo(presentaciones::class, 'id_presentacion');
    }
}
