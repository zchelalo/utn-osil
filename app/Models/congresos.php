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
        'id_organizacion',
    ];

    public function organizaciones()
    {
        return $this->belongsTo(organizaciones::class, 'id_organizacion');
    }
}
