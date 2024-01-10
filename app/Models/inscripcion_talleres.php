<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inscripcion_talleres extends Model
{
    use HasFactory;

    protected $table = 'inscripcion_talleres';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_congreso',
        'id_presentacion',
        'id_usuario'
    ];

    public function congresos()
    {
        return $this->belongsTo(congresos::class, 'id_congreso');
    }
    
    public function presentaciones()
    {
        return $this->belongsTo(presentaciones::class, 'id_presentacion');
    }

    public function usuarios()
    {
        return $this->belongsTo(usuarios::class, 'id_usuario');
    }
}
