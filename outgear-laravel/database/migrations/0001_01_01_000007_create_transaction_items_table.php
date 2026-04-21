<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('gear_id')->constrained()->onDelete('cascade');
            $table->string('gear_name', 100);
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('price_per_day')->default(0);
            $table->unsignedInteger('subtotal')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
