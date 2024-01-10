<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inscripcion_congresos extends Model
{
    use HasFactory;

    protected $table = 'inscripcion_congresos';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_congreso',
        'id_usuario'
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
