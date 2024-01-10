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
        Schema::create('inscripcion_talleres', function (Blueprint $table) {
            $table->id();
            $table->integer('id_congreso')->nullable()->foreign('id_congreso')->references('id')->on('congresos');
            $table->integer('id_presentacion')->foreign('id_presentacion')->references('id')->on('presentaciones');
            $table->integer('id_usuario')->foreign('id_usuario')->references('id')->on('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion_talleres');
    }
};
