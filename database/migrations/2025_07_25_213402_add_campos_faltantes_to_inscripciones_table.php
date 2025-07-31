<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposFaltantesToInscripcionesTable extends Migration
{
    public function up()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            if (!Schema::hasColumn('inscripciones', 'asistente_id')) {
                $table->foreignId('asistente_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('inscripciones', 'entrada_id')) {
                $table->foreignId('entrada_id')->nullable()->constrained()->onDelete('set null');
            }

            if (!Schema::hasColumn('inscripciones', 'valor_pago')) {
                $table->decimal('valor_pago', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('inscripciones', 'estado_pago')) {
                $table->enum('estado_pago', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');
            }
        });
    }

    public function down()
    {
        Schema::table('inscripciones', function (Blueprint $table) {
            if (Schema::hasColumn('inscripciones', 'asistente_id')) {
                $table->dropForeign(['asistente_id']);
                $table->dropColumn('asistente_id');
            }

            if (Schema::hasColumn('inscripciones', 'entrada_id')) {
                $table->dropForeign(['entrada_id']);
                $table->dropColumn('entrada_id');
            }

            if (Schema::hasColumn('inscripciones', 'valor_pago')) {
                $table->dropColumn('valor_pago');
            }

            if (Schema::hasColumn('inscripciones', 'estado_pago')) {
                $table->dropColumn('estado_pago');
            }
        });
    }
}
