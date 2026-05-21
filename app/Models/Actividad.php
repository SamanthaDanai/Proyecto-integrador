<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividad';
    protected $primaryKey = 'id_actividad';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'horario',
        'fecha_inicio',
        'fecha_final',
        'cupo',
        'requerimiento',
        'id_area',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'imparte', 'id_actividad', 'no_empleado');
    }

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'inscribe', 'id_actividad', 'num_control')
                    ->withPivot('periodo', 'calificacion', 'obs');
    }
}
