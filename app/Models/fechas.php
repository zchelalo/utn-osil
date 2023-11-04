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
        'id_taller',
        'id_conferencia',
        'id_congreso',
    ];
}
