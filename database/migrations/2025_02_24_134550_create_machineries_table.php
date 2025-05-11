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
        Schema::create('machineries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('description')->nullable();
            $table->foreignId('machinery_category_id')->constrained('machinery_categories');
            $table->foreignId('machinery_brand_id')->constrained('machinery_brands');
            $table->string('thumbnail');
            $table->json('attachments')->nullable();
            $table->integer('amount')->default(0);
            $table->integer('discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machineries');
    }
};
