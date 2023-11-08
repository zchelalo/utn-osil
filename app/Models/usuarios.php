<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class usuarios extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'matricula',
        'correo',
        'password',
        'id_tipo_usuario',
    ];

    protected $hidden = [
        'password',
    ];

    public function tipo_usuarios()
    {
        return $this->belongsTo(tipo_usuarios::class, 'id_tipo_usuario');
    }
}
