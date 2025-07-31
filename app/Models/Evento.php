<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'titulo', 'descripcion', 'es_gratuito', 'fecha_apertura', 'fecha_cierre',
        'fecha_evento', 'hora_evento', 'lugar', 'cupo_disponible',
        'valor_base', 'categoria_id',
    ];

    protected $casts = [
        'es_gratuito' => 'boolean',
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function listaEspera()
    {
        return $this->hasMany(ListaEspera::class);
    }

    public function cupones()
    {
        return $this->belongsToMany(Cupon::class, 'cupon_inscripcion');
    }

    // Formato de valor en pesos
    public function getValorBaseFormatoAttribute()
    {
        return '$' . number_format($this->valor_base, 0, ',', '.');
    }

    // (Opcional: si ya no usas tipos de entradas como modelo, puedes eliminar esta)
    // public function entradas()
    // {
    //     return $this->belongsToMany(Entrada::class, 'evento_entradas');
    // }
}
