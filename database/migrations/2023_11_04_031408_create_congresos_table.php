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
        Schema::create('congresos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255)->unique();
            $table->text('descripcion');
            $table->json('img')->nullable();
            $table->integer('numero_vistas')->unsigned()->default(1);
            $table->double('precio')->unsigned()->default(0);
            $table->integer('max_ins_taller')->unsigned()->default(1);
            $table->boolean('activo')->default(true);
            $table->integer('id_organizacion')->foreign('id_organizacion')->references('id')->on('organizaciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congresos');
    }
};
