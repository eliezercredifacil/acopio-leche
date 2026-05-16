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
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();

            // Productor
            $table->foreignId('productor_id')->constrained('productors')->restrictOnDelete();

            // Localidad (útil para reportes)
            $table->foreignId('localidad_id')->constrained('localidads')->restrictOnDelete();

            // Fecha de la deducción
            $table->date('semana_inicio');

            // Tipo de deducción
            $table->enum('tipo', ['efectivo', 'combustible', 'alimentos', 'lacteos', 'otros']);

            // Monto
            $table->decimal('monto', 12, 2);

            // Comentario opcional
            $table->string('descripcion')->nullable();

            // Índices
            $table->unique(['productor_id','semana_inicio','tipo']);
            
            $table->index(['semana_inicio','localidad_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
