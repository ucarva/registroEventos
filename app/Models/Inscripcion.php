<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use HasFactory;
use Illuminate\Support\Facades\DB;

class Inscripcion extends Model
{


    protected $table = 'inscripciones';
    protected $fillable = [
        'evento_id',
        'asistente_id',
        'entrada_id',
        'valor_pago',
        'valor_pendiente',
        'estado_pago'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function asistente()
    {
        return $this->belongsTo(Asistente::class);
    }

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }

    public static function getEstadosPago(): array
    {
        $type = DB::select("SHOW COLUMNS FROM inscripciones WHERE Field = 'estado_pago'")[0]->Type;

        preg_match('/^enum\((.*)\)$/', $type, $matches);

        $enum = [];

        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum[$v] = ucfirst(str_replace('_', ' ', $v)); // Ej: "pendiente_pago" => "Pendiente pago"
        }

        return $enum;
    }
}
