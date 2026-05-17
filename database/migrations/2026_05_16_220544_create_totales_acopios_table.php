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
        Schema::create('totales_acopios', function (Blueprint $table) {
            $table->id();
            // Localidad
            $table->foreignId('localidad_id')->constrained('localidads')->restrictOnDelete();

            // Fecha
            $table->date('fecha');
            $table->enum('tipo_semana', ['A', 'B']);
            // Litros reales en acopio
            $table->decimal('litros', 10, 2);

            // 1 registro por día/localidad
            $table->unique(['localidad_id','fecha','tipo_semana']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('totales_acopios');
    }
};
