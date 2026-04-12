<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuario'; // tu tabla real en la BD

    protected $primaryKey = 'num_control';

    public $incrementing = false;

    protected $fillable = [
        'num_control',
        'nombre',
        'apat',
        'amat',
        'genero',
        'turno',
        'correo_inst',
        'carrera',
        'generacion',
        'actividad_extraescolar',
        'id_tipo',
        'contrasena'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipo', 'id_tipo');
    }

    public function actividad()
    {
        return $this->belongsTo(ActExtraescolar::class, 'actividad_extraescolar', 'id_act');
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
