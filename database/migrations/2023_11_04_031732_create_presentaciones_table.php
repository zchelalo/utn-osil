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
        Schema::create('presentaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->string('img', 255)->nullable();
            $table->json('presentacion')->nullable();
            $table->integer('numero_vistas')->unsigned()->default(1);
            $table->integer('id_tipo_presentacion')->foreign('id_tipo_presentacion')->references('id')->on('tipo_presentaciones');
            $table->integer('id_congreso')->nullable()->foreign('id_congreso')->references('id')->on('congresos');
            $table->integer('id_usuario')->foreign('id_usuario')->references('id')->on('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentaciones');
    }
};
