<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mantencion_items', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_equipo');
            $table->string('seccion');
            $table->string('descripcion');
            $table->enum('tipo_respuesta', ['A', 'B']);
            $table->boolean('es_critico')->default(false);
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mantencion_items');
    }
};