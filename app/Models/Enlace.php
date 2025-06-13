<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enlace extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'enlaces';

    // Clave primaria
    protected $primaryKey = 'id_enlace';

    // Hacer la clave primaria auto-incremental (si no es así)
    public $incrementing = true;

    // Deshabilitar timestamps si no se usan (no parece que tengas campos `created_at` o `updated_at`)
    public $timestamps = false;

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_users',
        'nombre',
        'url',
        'fecha_creacion',
        'fecha_fin',
    ];

    protected $dates = [
        'fecha_creacion',
        'fecha_fin', // Especifica que el campo 'fecha' debe ser tratado como una fecha.
    ];

    protected $casts = [
        'fecha_creacion' => 'date',
        'fecha_fin' => 'date',
    ];


    // Relación: Un enlace pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
