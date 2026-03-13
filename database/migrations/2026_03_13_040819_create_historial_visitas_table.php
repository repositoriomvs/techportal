<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tipo'); // documento, hardware_recurso
            $table->unsignedBigInteger('recurso_id');
            $table->string('recurso_nombre');
            $table->string('recurso_url');
            $table->integer('ultima_pagina')->default(1);
            $table->timestamp('visitado_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_visitas');
    }
};