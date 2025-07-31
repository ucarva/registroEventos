<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Entrada.php

class Entrada extends Model
{
    protected $table = 'entradas';
    protected $fillable = ['tipo_entrada', 'porcentaje_adicional'];

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_entradas');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
    // App\Models\Entrada.php
public function calcularValorConEvento(Evento $evento): float
{
    return $evento->valor_base + ($evento->valor_base * $this->porcentaje_adicional / 100);
}

}
