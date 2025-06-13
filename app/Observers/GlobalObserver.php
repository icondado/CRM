<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class GlobalObserver
{
    protected function crearDescripcion($accion, Model $model): string
    {
        $modeloNombre = class_basename($model);

        if ($modeloNombre === 'User') {
            $nombreCompleto = $model->nombre . ' ' . $model->apellidos;
            $tipo = $model->permisos == 0 ? 'Admin' : 'Usuario';

            return match ($accion) {
                'created' => "Se creó el usuario {$nombreCompleto} con permiso de tipo {$tipo}.",
                'updated' => "Se actualizó el usuario {$nombreCompleto}.",
                'deleted' => "Se eliminó el usuario {$nombreCompleto}.",
                default => "{$accion} sobre usuario {$nombreCompleto}.",
            };
        }

        // Otros modelos: descripción genérica
        return ucfirst($accion) . ' sobre registro ' . $model->getKey() . ' en la tabla ' . $model->getTable() . '.';
    }
    public function created(Model $model)
    {
        $this->registrar('created', $model);
    }

    public function updated(Model $model)
    {
        $this->registrar('updated', $model);
    }

    public function deleted(Model $model)
    {
        $this->registrar('deleted', $model);
    }

    protected function registrar($accion, Model $model)
    {
        // Evitar registrar logs del propio modelo Log
        if ($model instanceof Log) {
            return;
        }

        $descripcion = $this->crearDescripcion($accion, $model);

        Log::create([
            'id_users'  => Auth::check() ? Auth::id() : null,
            'tabla_afectada' => $model->getTable(),
            'accion' => $accion,
            'registro_id' => $model->getKey(),
            //'descripcion' => json_encode($model->toArray(), JSON_UNESCAPED_UNICODE),
            'descripcion' => $descripcion,
            'fecha' => now(),
        ]);
    }
}
