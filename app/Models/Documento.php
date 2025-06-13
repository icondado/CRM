<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'documentos';

    // Clave primaria
    protected $primaryKey = 'id_documento';

    // Deshabilitar timestamps si no se usan (no parece que tengas campos `created_at` o `updated_at`)
    public $timestamps = false;

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_users',
        'nombre',
        'descripcion',
        'file',
        'fecha_alta',
        'id_carpeta',
    ];

    // Relación: Un documento pertenece a una carpeta
    public function carpeta()
    {
        return $this->belongsTo(Carpeta::class, 'id_carpeta', 'id_carpeta');
    }

    // Relación: un documento pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
