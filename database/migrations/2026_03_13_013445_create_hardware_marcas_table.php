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
    Schema::create('hardware_marcas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hardware_tipo_id')->constrained()->onDelete('cascade');
        $table->string('nombre');
        $table->string('icono')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_marcas');
    }
};
