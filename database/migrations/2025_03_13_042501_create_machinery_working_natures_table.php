<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('machinery_working_natures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });



        if (Schema::hasTable('machineries')) {

            if (Schema::hasColumn('machineries', 'machinery_working_nature_id')) {
                Schema::table('machineries', function (Blueprint $table) {
                    $table->foreignId('machinery_working_nature_id')->constrained('machinery_working_natures');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        if (Schema::hasTable('machineries')) {
            if (Schema::hasColumn('machineries', 'machinery_working_nature_id')) {
                Schema::table('machineries', function (Blueprint $table) {
                    $table->dropForeign(['machinery_working_nature_id']);
                    $table->dropColumn('machinery_working_nature_id');

                });
            }
        }

        Schema::dropIfExists('machinery_working_natures');
    }
};
