<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    // ✅ El nombre de la tabla que realmente existe en tu base de datos
    protected $table = 'asistentes';
    
    protected $fillable = [
        'nombre', 
        'apellido',
        'fecha_nacimiento',
        'email',
        'celular'
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function listaEspera()
    {
        return $this->hasMany(ListaEspera::class);
    }
}
