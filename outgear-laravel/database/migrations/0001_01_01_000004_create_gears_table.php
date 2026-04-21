<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gears', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('category', 100);
            $table->string('category_id', 50)->default('');
            $table->unsignedInteger('price_per_day')->default(0);
            $table->unsignedInteger('stock')->default(1);
            $table->enum('condition', ['Baik', 'Cukup', 'Rusak'])->default('Baik');
            $table->boolean('is_available')->default(true);
            $table->text('description')->nullable();
            $table->string('image', 2048)->default('');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gears');
    }
};
