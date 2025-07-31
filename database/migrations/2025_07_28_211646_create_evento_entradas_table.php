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
    Schema::create('evento_entradas', function (Blueprint $table) {
        $table->id();

        // Definir columnas antes de aplicar claves foráneas
        $table->unsignedBigInteger('evento_id');
        $table->unsignedBigInteger('entrada_id');

        $table->timestamps();

        // Aplicar claves foráneas
        $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_entradas');
    }
};
