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
        Schema::create('productors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('localidad_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            // Información del productor            
            $table->string('nombre', 150);
            $table->string('cedula', 30)->nullable()->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->boolean('activo')->default(true);
            $table->enum('semana', ['A', 'B']);
            $table->string('foto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productors');
    }
};
