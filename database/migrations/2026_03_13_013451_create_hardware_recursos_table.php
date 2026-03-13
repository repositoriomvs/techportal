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
    Schema::create('hardware_recursos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hardware_modelo_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('hardware_tipo_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->enum('categoria', ['manual_tecnico', 'list_part', 'firmware', 'procedimiento']);
        $table->enum('tipo', ['PDF', 'ISO', 'EXE', 'IMG', 'ZIP', 'LINK']);
        $table->string('version')->nullable();
        $table->string('tamanio')->nullable();
        $table->string('archivo')->nullable();
        $table->string('url')->nullable();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_recursos');
    }
};
