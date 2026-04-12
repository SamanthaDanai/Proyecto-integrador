<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carrera';
    protected $primaryKey = 'id_carrera';

    // Para habilitar el uso correcto en el resource routing (model binding)
    public function getRouteKeyName()
    {
        return 'id_carrera';
    }

    public $timestamps = false;

    protected $fillable = [
        'nombre_carrera',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
