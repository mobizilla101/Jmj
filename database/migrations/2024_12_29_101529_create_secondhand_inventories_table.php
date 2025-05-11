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
        Schema::create('secondhand_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sku_id')->constrained('skus');
            $table->string('imei')->unique()->index();
            $table->string('serial_number')->unique()->index();
            $table->date('purchase_date');
            $table->text('description');
            $table->integer('discount')->default(0);
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondhand_inventories');
    }
};
