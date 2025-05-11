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
        Schema::create('mw_nature_brand', function (Blueprint $table) { // Shorter table name
            $table->id();

            $table->foreignId('mw_nature_id') // Shorter column name
                ->constrained('machinery_working_natures')
                ->onDelete('cascade')
                ->index('fk_mw_nature'); // Shorter foreign key name

            $table->foreignId('mw_brand_id') // Shorter column name
                ->constrained('machinery_brands')
                ->onDelete('cascade')
                ->index('fk_mw_brand'); // Shorter foreign key name

            $table->unique(['mw_nature_id', 'mw_brand_id'], 'mw_nature_brand_unique'); // Shorter unique constraint name

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mw_nature_brand');
    }
};
