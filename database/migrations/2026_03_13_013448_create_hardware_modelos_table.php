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
    Schema::create('hardware_modelos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hardware_marca_id')->constrained()->onDelete('cascade');
        $table->string('nombre');
        $table->string('numero_parte')->nullable();
        $table->text('descripcion')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hardware_modelos');
    }
};
