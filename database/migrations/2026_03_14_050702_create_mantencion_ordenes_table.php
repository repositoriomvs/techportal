<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mantencion_ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('numero_orden')->unique()->nullable();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_termino')->nullable();
            $table->string('codigo_local')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('firma_nombre')->nullable();
            $table->string('firma_cargo')->nullable();
            $table->text('firma_imagen')->nullable();
            $table->enum('estado', ['borrador','enviada'])->default('borrador');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mantencion_ordenes');
    }
};