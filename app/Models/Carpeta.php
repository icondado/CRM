<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'carpetas';

    // Clave primaria
    protected $primaryKey = 'id_carpeta';

    // Deshabilitar timestamps si no se usan (no parece que tengas campos `created_at` o `updated_at`)
    public $timestamps = false;

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_carpeta',
        'nombre_original',
        'id_users',
    ];

    // Relación: Una carpeta pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    // Relación: Una carpeta tiene muchos documentos
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'id_carpeta', 'id_carpeta');
    }

    // Accessor para obtener el nombre limpio
    public function getNombreLimpioAttribute()
    {
        return preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->nombre_original);
    }
}
