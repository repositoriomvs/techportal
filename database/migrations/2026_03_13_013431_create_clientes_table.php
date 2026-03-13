<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('codigo')->unique();
        $table->string('contacto')->nullable();
        $table->string('email')->nullable();
        $table->string('telefono')->nullable();
        $table->enum('estado', ['activo', 'inactivo'])->default('activo');
        $table->string('color', 7)->default('#c84b2f');
        $table->text('notas')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};