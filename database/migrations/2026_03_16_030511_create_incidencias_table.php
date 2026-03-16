<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('numero_ticket')->unique();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('local_id')->constrained('locales');
            $table->foreignId('agente_id')->constrained('users');
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('canal_ingreso');
            $table->string('nombre_contacto');
            $table->string('telefono_contacto');
            $table->enum('tipo_ticket', ['incidencia_hardware', 'incidencia_software', 'requerimiento']);
            $table->enum('categoria_equipo', ['computador', 'impresora', 'pos', 'periferico']);
            $table->string('tipo_equipo');
            $table->string('marca_equipo')->nullable();
            $table->string('modelo_equipo')->nullable();
            $table->string('serie_equipo')->nullable();
            $table->boolean('serie_temporal')->default(false);
            $table->string('ubicacion_equipo')->nullable();
            $table->string('asunto');
            $table->text('descripcion_falla');
            $table->string('adjunto')->nullable();
            $table->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
            $table->enum('estado_mesa', [
                'abierto', 'en_gestion', 'asignado', 'pendiente_cliente', 'cancelado_cliente', 'cerrado'
            ])->default('abierto');
            $table->enum('estado_tecnico', [
                'asignado', 'en_progreso', 'cerrado', 'pendiente'
            ])->nullable();
            $table->string('categoria_cierre')->nullable();
            $table->string('subcategoria_cierre')->nullable();
            $table->text('comentario_cierre')->nullable();
            $table->string('serie_equipo_real')->nullable();
            $table->timestamp('fecha_asignacion')->nullable();
            $table->timestamp('fecha_limite_respuesta')->nullable();
            $table->timestamp('fecha_limite_resolucion')->nullable();
            $table->timestamp('fecha_primera_atencion')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};