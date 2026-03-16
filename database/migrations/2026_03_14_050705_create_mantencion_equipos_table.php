<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mantencion_equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mantencion_orden_id')->constrained('mantencion_ordenes')->cascadeOnDelete();
            $table->enum('tipo', [
                'impresora_sin_adf',
                'impresora_con_adf',
                'impresora_termica',
                'computador_aio',
                'computador_desktop',
                'computador_notebook'
            ]);
            $table->string('marca');
            $table->string('modelo');
            $table->string('serie');
            $table->text('observaciones')->nullable();
            $table->enum('estado_final', [
                'operativo',
                'operativo_con_observaciones',
                'defectuoso'
            ])->nullable();
            $table->string('foto_equipo')->nullable();
            $table->string('foto_serie')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('mantencion_equipos');
    }
};