<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->boolean('tiene_sla')->default(false)->after('notas');
            $table->integer('sla_horas_respuesta')->default(0)->after('tiene_sla');
            $table->integer('sla_horas_resolucion')->default(0)->after('sla_horas_respuesta');
            $table->integer('sla_horas_cambio_equipo')->default(0)->after('sla_horas_resolucion');
        });
    }

    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn([
                'tiene_sla',
                'sla_horas_respuesta',
                'sla_horas_resolucion',
                'sla_horas_cambio_equipo',
            ]);
        });
    }
};
