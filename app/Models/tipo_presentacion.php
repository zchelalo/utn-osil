<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_presentacion extends Model
{
    use HasFactory;

    protected $table = 'tipo_presentaciones';

    protected $fillable = [
        'nombre',
    ];

    public function presentaciones()
    {
        return $this->hasMany(presentaciones::class, 'id_tipo_presentacion');
    }
}
