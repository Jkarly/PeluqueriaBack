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
        Schema::create('empleado__especialidads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_empleado')->constrained('empleados')->onDelete('cascade');
            $table->foreignId('id_especialidad')->constrained('especialidads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleado__especialidads');
    }
};
