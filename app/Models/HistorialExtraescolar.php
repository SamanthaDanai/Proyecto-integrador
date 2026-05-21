<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialExtraescolar extends Model
{
    use HasFactory;

    protected $table = 'historial_extraescolar';

    protected $primaryKey = 'id_historial';

    public $timestamps = false;

    protected $fillable = [
        'num_control',
        'id_act',
        'tipo',
        'periodo',
        'numero_periodo',
        'calificacion_final',
        'estado',
        'firma_estudiante',
        'validacion_admin'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'num_control', 'num_control');
    }

    public function actividadExtraescolar()
    {
        return $this->belongsTo(ActExtraescolar::class, 'id_act', 'id_act');
    }

    public function parciales()
    {
        return $this->hasMany(CalificacionParcial::class, 'id_historial', 'id_historial');
    }
}
