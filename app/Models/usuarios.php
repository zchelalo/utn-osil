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
        'foto_perfil',
        'redes_sociales',
        'id_tipo_usuario',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'redes_sociales' => 'array',
    ];

    public function tipo_usuario()
    {
        return $this->belongsTo(tipo_usuario::class, 'id_tipo_usuario');
    }
}
