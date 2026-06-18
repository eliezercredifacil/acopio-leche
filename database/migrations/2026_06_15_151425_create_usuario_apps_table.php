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
        Schema::create('usuarios_app', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('pin', 4);
            $table->unsignedBigInteger('localidad_id');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->foreign('localidad_id')->references('id')->on('localidads');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_apps');
    }
};
