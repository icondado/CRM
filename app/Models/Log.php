<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'logs';

    public $timestamps = false;

    // Clave primaria
    protected $primaryKey = 'id_log';

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_users',
        'tabla_afectada',
        'accion',
        'registro_id',
        'descripcion',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];


    // Relación: Un log pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
