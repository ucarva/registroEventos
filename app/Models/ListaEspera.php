<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaEspera extends Model
{
    protected $fillable = ['evento_id', 'asistente_id'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function asistente()
    {
        return $this->belongsTo(Asistente::class);
    }
}
