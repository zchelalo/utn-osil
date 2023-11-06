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
        Schema::create('fechas', function (Blueprint $table) {
            $table->id();
            $table->date('dia');
            $table->time('inicio');
            $table->time('fin');
            $table->integer('id_presentacion')->foreign('id_presentacion')->references('id')->on('presentaciones');
            $table->integer('id_congreso')->foreign('id_congreso')->references('id')->on('congresos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fechas');
    }
};
