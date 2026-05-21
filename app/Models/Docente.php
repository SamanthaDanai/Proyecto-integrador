<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docente';
    protected $primaryKey = 'no_empleado';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    // Para habilitar el uso correcto en el resource routing (model binding)
    public function getRouteKeyName()
    {
        return 'no_empleado';
    }

    protected $fillable = [
        'no_empleado',
        'nombre',
        'apet',
        'amat',
        'correo',
        'genero',
        'fotografia',
        'perfil',
        'telefono',
        'area',
        'activo',
    ];

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'imparte', 'no_empleado', 'id_actividad')
                    ->withPivot('periodo');
    }
}
