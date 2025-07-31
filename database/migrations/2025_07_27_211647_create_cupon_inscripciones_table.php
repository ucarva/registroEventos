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
   Schema::create('cupon_inscripcion', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('cupon_id');
    $table->unsignedBigInteger('inscripcion_id');
    $table->unsignedBigInteger('evento_id'); // <- Este es el que falta
    $table->timestamps();

    // Claves foráneas
    $table->foreign('cupon_id')->references('id')->on('cupones')->onDelete('cascade');
    $table->foreign('inscripcion_id')->references('id')->on('inscripciones')->onDelete('cascade');
    $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupon_inscripcion');
    }
};
