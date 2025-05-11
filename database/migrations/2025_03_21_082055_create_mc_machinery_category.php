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
        Schema::create('mc_machinery_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mc_working_natures_id') // Shorter column name
            ->constrained('machinery_working_natures')
                ->onDelete('cascade')
                ->index('fk_mc_working_nature'); // Shorter foreign key name

            $table->foreignId('mc_category_id') // Shorter column name
            ->constrained('machinery_categories')
                ->onDelete('cascade')
                ->index('fk_mc_category'); // Shorter foreign key name

            $table->unique(['mc_working_natures_id', 'mc_category_id'], 'mc_nature_category_unique'); // Shorter unique constraint name

            $table->timestamps();
        });

        if(Schema::hasTable('machinery_categories')){
            if(Schema::hasColumn('machinery_categories','machinery_working_nature_id')){
                Schema::table('machinery_categories', function (Blueprint $table) {
                    $table->dropForeign(['machinery_working_nature_id']);
                    $table->dropColumn('machinery_working_nature_id');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mc_machinery_category');
    }
};
