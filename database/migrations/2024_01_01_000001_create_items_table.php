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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('category')->default('Umum');
            $table->integer('quantity')->default(0);
            $table->string('location')->nullable();
            $table->enum('condition', ['Baik', 'Rusak', 'Perlu Perbaikan'])->default('Baik');
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('category');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
