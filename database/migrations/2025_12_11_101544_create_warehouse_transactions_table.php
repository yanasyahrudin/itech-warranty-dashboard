<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['received', 'issued']); // received = masuk, issued = keluar
            $table->integer('quantity');
            $table->string('destination')->nullable(); // untuk issued
            $table->text('notes')->nullable();
            $table->foreignId('transaction_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['product_id', 'type']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_transactions');
    }
};