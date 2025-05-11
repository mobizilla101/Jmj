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
        Schema::create('skus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->constrained('models');
            $table->unsignedInteger('storage');
            $table->unsignedInteger('memory');
            $table->integer('discount')->default(0);
            $table->unsignedInteger('price');
            $table->boolean('hot_sale')->default(false);
            $table->timestamps();

            $table->unique(['model_id', 'storage', 'memory'], 'unique_model_storage_memory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skus');
    }
};
