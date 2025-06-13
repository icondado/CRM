<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Carpeta;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Nombre de la tabla
    protected $table = 'users';

    // Clave primaria
    protected $primaryKey = 'id_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellidos',
        'dni',
        'direccion',
        'codigo_postal',
        'provincia',
        'telefono',
        'email',
        'password',
        'permisos',
        'activo',
        'fecha_alta',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Deshabilitar timestamps si no se usan (no parece que tengas campos `created_at` o `updated_at`)
    public $timestamps = false;

    // Relación: Un usuario tiene muchas carpetas
    public function carpetas()
    {
        return $this->hasMany(Carpeta::class, 'id_users', 'id_users');
    }

    // Relación: Un usuario tiene muchos logs
    public function logs()
    {
        return $this->hasMany(Log::class, 'id_users', 'id_users');
    }

    // Relación: Un usuario tiene muchos enlaces
    public function enlaces(): HasMany
    {
        return $this->hasMany(Enlace::class, 'id_users', 'id_users');
    }

    // Relación: Un usuario tiene muchos documentos
    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class, 'id_users', 'id_users');
    }


    // Relación: Un usuario tiene muchos eventos
    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'id_users', 'id_users');
    }

    public function getAuthIdentifierName()
    {
        return 'id_users';
    }
}
