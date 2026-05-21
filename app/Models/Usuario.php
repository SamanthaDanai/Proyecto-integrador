<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;

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
        'contrasena',
        'fotografia_perfil'
    ];

    protected $hidden = [
        'contrasena',
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipo', 'id_tipo');
    }

    public function actividad()
    {
        return $this->belongsTo(ActExtraescolar::class, 'actividad_extraescolar', 'id_act');
    }

    public function historial_extraescolar()
    {
        return $this->hasMany(HistorialExtraescolar::class, 'num_control', 'num_control');
    }

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'inscribe', 'num_control', 'id_actividad')
                    ->withPivot('periodo', 'calificacion', 'obs');
    }

    public function docente()
    {
        return $this->hasOne(Docente::class, 'no_empleado', 'num_control');
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
