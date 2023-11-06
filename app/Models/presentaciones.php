<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presentaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'img',
        'presentacion',
        'id_tipo_presentacion',
        'id_congreso',
        'id_usuario',
    ];

    public function fechas()
    {
        return $this->hasOne(fechas::class, 'id_presentacion');
    }

    public function congresos()
    {
        return $this->belongsTo(congresos::class, 'id_congreso');
    }

    public function usuarios()
    {
        return $this->belongsTo(usuarios::class, 'id_usuario');
    }

    public function tipo_presentacion()
    {
        return $this->belongsTo(tipo_presentacion::class, 'id_tipo_presentacion');
    }
}
