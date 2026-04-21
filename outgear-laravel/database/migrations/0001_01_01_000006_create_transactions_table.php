<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer_name', 100);
            $table->string('customer_email')->default('');
            $table->foreignId('leader_id')->nullable()->constrained()->nullOnDelete();
            $table->string('leader_name', 100)->default('');
            $table->unsignedInteger('leader_fee')->default(0);
            $table->date('rental_start');
            $table->date('rental_end');
            $table->date('return_date')->nullable();
            $table->unsignedInteger('total_days')->default(1);
            $table->unsignedInteger('gear_cost')->default(0);
            $table->unsignedInteger('leader_cost')->default(0);
            $table->unsignedInteger('late_fee')->default(0);
            $table->unsignedInteger('total_cost')->default(0);
            $table->enum('status', [
                'Menunggu Konfirmasi',
                'Dikonfirmasi',
                'Dipinjam',
                'Dikembalikan',
                'Terlambat',
                'Selesai',
                'Ditolak',
            ])->default('Menunggu Konfirmasi');
            $table->text('rejection_reason')->nullable();
            $table->string('payment_proof', 2048)->default('');
            $table->boolean('payment_confirmed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
