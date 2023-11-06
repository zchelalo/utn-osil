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
		Schema::create('usuarios', function (Blueprint $table) {
			$table->id();
			$table->string('nombre', 255);
			$table->integer('matricula')->nullable()->unsigned()->unique();
			$table->string('correo', 255)->unique();
			$table->string('password', 255);
			$table->integer('id_tipo_usuario')->foreign('id_tipo_usuario')->references('id')->on('tipo_usuario');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('usuarios');
	}
};
