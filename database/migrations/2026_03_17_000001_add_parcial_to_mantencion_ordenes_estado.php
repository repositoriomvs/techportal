<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE mantencion_ordenes DROP CONSTRAINT mantencion_ordenes_estado_check');
        DB::statement("ALTER TABLE mantencion_ordenes ADD CONSTRAINT mantencion_ordenes_estado_check CHECK (estado::text = ANY (ARRAY['borrador'::text, 'enviada'::text, 'parcial'::text]))");
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE mantencion_ordenes DROP CONSTRAINT mantencion_ordenes_estado_check');
        DB::statement("ALTER TABLE mantencion_ordenes ADD CONSTRAINT mantencion_ordenes_estado_check CHECK (estado::text = ANY (ARRAY['borrador'::text, 'enviada'::text]))");
    }
};