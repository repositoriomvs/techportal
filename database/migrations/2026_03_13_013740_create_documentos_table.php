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
    Schema::create('documentos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->enum('categoria', ['documento', 'procedimiento', 'imagen']);
        $table->enum('tipo', ['PDF', 'ISO', 'EXE', 'IMG', 'ZIP', 'LINK']);
        $table->string('version')->nullable();
        $table->string('tamanio')->nullable();
        $table->string('archivo')->nullable();
        $table->string('url')->nullable();
        $table->string('icono')->default('📄');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
