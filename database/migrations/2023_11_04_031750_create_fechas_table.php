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
            $table->date('dia_fin')->nullable();
            $table->time('inicio');
            $table->time('fin');
            $table->integer('id_taller')->nullable()->foreign('id_taller')->references('id')->on('talleres');
            $table->integer('id_conferencia')->nullable()->foreign('id_conferencia')->references('id')->on('conferencias');
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
