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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->boolean('estado')->default(1);
            $table->decimal('duracionmin', 10, 2)->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('imagen')->nullable(); 
            $table->text('descripcion')->nullable();
            $table->foreignId('idcategoria')->constrained('categorias')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};