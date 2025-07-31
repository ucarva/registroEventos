<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Categoria.php

class Categoria extends Model
{
    // ✅ El nombre de la tabla que realmente existe en tu base de datos
    protected $table = 'categorias';
    protected $fillable = ['nombre_categoria'];

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
