<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Inscribe extends Pivot
{
    protected $table = 'inscribe';
    public $timestamps = false;

    protected $fillable = [
        'num_control',
        'id_actividad',
        'periodo',
        'calificacion',
        'obs',
    ];
}
