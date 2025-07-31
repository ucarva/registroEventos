<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('eventos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('descripcion');
        $table->date('fecha_apertura');
        $table->date('fecha_cierre');
        $table->date('fecha_evento');
        $table->time('hora_evento');
        $table->string('lugar');
        $table->integer('cupo_disponible');
        $table->decimal('valor_base', 10, 2);
        $table->timestamps();

        // Claves foráneas: primero definidas, luego relacionadas
        $table->unsignedBigInteger('categoria_id');
        

        $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
