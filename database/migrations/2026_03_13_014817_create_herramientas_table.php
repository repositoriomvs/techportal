<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('herramientas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nombre');
            $table->string('categoria'); // libre, ej: "Diagnóstico", "Red", "Sistema"
            $table->enum('tipo', ['ISO', 'EXE', 'LINK', 'ZIP', 'PDF']);
            $table->string('archivo')->nullable();
            $table->string('url')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('tamanio')->nullable();
            $table->string('icono')->nullable();
            $table->string('version')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('herramientas');
    }
};