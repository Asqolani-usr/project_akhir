<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'payment_confirmed',
                'status_changed',
                'overdue_warning',
                'booking_confirmed',
                'return_reminder',
            ]);
            $table->string('title');
            $table->text('message');
            $table->foreignId('transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('icon')->default('');
            $table->boolean('read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
