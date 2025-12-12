<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('serial_number')->unique();
            $table->enum('status', ['available', 'registered', 'used'])->default('available');
            $table->foreignId('registered_to')->nullable()->constrained('warranty_registrations')->onDelete('set null');
            $table->timestamp('registered_at')->nullable();
            $table->timestamps();
            
            $table->index(['product_id', 'status']);
            $table->index('serial_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_serial_numbers');
    }
};