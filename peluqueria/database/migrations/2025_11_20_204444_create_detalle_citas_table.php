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
        Schema::create('detalle_citas', function (Blueprint $table) {
            $table->id();
            $table->boolean('estado')->default(0);
            $table->decimal('preciocobrado', 10, 2)->nullable();;
            $table->text('observaciones')->nullable();
            $table->foreignId('idcita')->constrained('citas')->onDelete('cascade'); 
            $table->foreignId('idservicio')->constrained('servicios')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_citas');
    }
};
