<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActExtraescolar extends Model
{
    use HasFactory;

    protected $table = 'Act_extraesc'; // Nombre real de tu tabla

    protected $primaryKey = 'id_act'; // Llave primaria correcta

    public $timestamps = false; // Si la tabla no tiene created_at / updated_at

    protected $fillable = [
        'nombre',
        'activo',
    ];

    // 🔥 Importante: permite que las rutas resource usen id_tipo
    public function getRouteKeyName()
    {
        return 'id_act';
    }
}
