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
    Schema::create('lista_esperas', function (Blueprint $table) {
        $table->id();

        // Debes definir primero las columnas
        $table->unsignedBigInteger('evento_id');
        $table->unsignedBigInteger('asistente_id');

        $table->timestamp('fecha_registro')->useCurrent();

        $table->timestamps();

        // Ahora sí puedes aplicar las claves foráneas
        $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        $table->foreign('asistente_id')->references('id')->on('asistentes')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_esperas');
    }
};
