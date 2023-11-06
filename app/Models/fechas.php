<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fechas extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'dia_fin',
        'inicio',
        'fin',
        'id_taller',
        'id_conferencia',
        'id_congreso',
    ];

    public function congresos()
    {
        return $this->belongsTo(congresos::class, 'id_congreso');
    }

    public function talleres()
    {
        return $this->belongsTo(talleres::class, 'id_taller');
    }

    public function conferencias()
    {
        return $this->belongsTo(conferencias::class, 'id_conferencia');
    }
}
