<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function deshabilitarFecha()
    {
        // Obtén la fecha actual y hora actual
        $fechaActual = now();
        
        // Crea una instancia de Carbon para el campo 'dia'
        $dia = $this->dia;

        // Crea una instancia de Carbon para el campo 'fin'
        $fin = $this->fin;

        $fechaFin = Carbon::parse($dia . ' ' . $fin);

        // Compara la fecha y hora actual con la fecha y hora de inicio y fin
        if ($fechaActual->greaterThanOrEqualTo($fechaFin)) {
            $this->activo = 0;
            $this->save();
        }
    }
}
