<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionesTable extends Migration
{
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evento_id')->constrained()->onDelete('cascade');
            $table->foreignId('asistente_id')->constrained()->onDelete('cascade'); // Relación al asistente

            $table->foreignId('entrada_id')->nullable()->constrained()->onDelete('set null'); // Tipo de entrada
            $table->decimal('valor_pago', 10, 2)->default(0); // Total pagado
            $table->decimal('valor_pendiente',10,2)->default(0);
            $table->enum('estado_pago', ['pendiente', 'pagado', 'cancelado'])->default('pendiente'); // Estado del pago

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscripciones');
    }
}
