<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reports_type_id')->constrained('reports_types');
        $table->foreignId('user_id')->constrained('users'); // já vem do Breeze
        $table->float('latitude');
        $table->float('longitude');
        $table->string('address')->nullable();
        $table->string('img')->nullable();
        $table->text('obs')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
{
    Schema::dropIfExists('reports');
}
};
