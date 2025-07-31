<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
     protected $table = 'cupones';
    protected $fillable = ['codigo_descuento', 'porcentaje_descuento', 'fecha_inicio', 'fecha_fin'];

    public function inscripciones()
    {
        return $this->belongsToMany(Inscripcion::class, 'cupon_inscripcion');
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'cupon_inscripcion');
    }
}
