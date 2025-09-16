<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('fire_levels', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reports_id')->constrained('reports');
        $table->integer('level');
        $table->timestamps();
    });
}

    public function down(): void
{
    Schema::dropIfExists('fire_levels');
}
};
