<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'eventos';

    // Clave primaria
    protected $primaryKey = 'id_evento';

    // Deshabilitar timestamps si no se usan (no parece que tengas campos `created_at` o `updated_at`)
    public $timestamps = false;

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_users',
        'titulo_evento',
        'descripcion_evento',
        'fecha_inicio_evento',
        'hora_inicio_evento',
        'fecha_fin_evento',
        'hora_fin_evento',
    ];

    // Relación: Un enlace pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
