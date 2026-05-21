<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionParcial extends Model
{
    use HasFactory;

    protected $table = 'calificaciones_parciales';

    protected $primaryKey = 'id_parcial';

    public $timestamps = false;

    protected $fillable = [
        'id_historial',
        'num_parcial',
        'asistencia',
        'participacion',
        'calificacion'
    ];

    public function historial()
    {
        return $this->belongsTo(HistorialExtraescolar::class, 'id_historial', 'id_historial');
    }
}
