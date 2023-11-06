<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conferencias extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'id_congreso',
        'id_usuario',
    ];

    public function congresos()
    {
        return $this->belongsTo(congresos::class, 'id_congreso');
    }

    public function usuarios()
    {
        return $this->belongsTo(usuarios::class, 'id_usuario');
    }
}
