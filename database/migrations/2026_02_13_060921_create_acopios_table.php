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
        Schema::create('acopios', function (Blueprint $table) {
            $table->id();
            // Relación con productor (NO cascada)
            $table->foreignId('productor_id')
                ->constrained('productors')
                ->restrictOnDelete();

            // Relación con localidad (opcional pero útil)
            $table->foreignId('localidad_id')
                ->constrained('localidads') // ajusta si tu tabla es "localidades"
                ->restrictOnDelete();

            $table->date('fecha');

            $table->decimal('litros', 10, 2);
            $table->decimal('precio', 10, 2);
            $table->decimal('total', 12, 2);

            $table->timestamps();

            // 🔥 Evita duplicados por día
            $table->unique(['productor_id', 'fecha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acopios');
    }
};
