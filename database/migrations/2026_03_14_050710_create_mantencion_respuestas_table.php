<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mantencion_respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mantencion_equipo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mantencion_item_id')->constrained()->cascadeOnDelete();
            $table->enum('respuesta', [
                'operativo',
                'defectuoso',
                'no_aplica',
                'realizado',
                'no_realizado'
            ]);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mantencion_respuestas');
    }
};