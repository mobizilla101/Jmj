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
        if (Schema::hasTable('machineries')) {
            if (!Schema::hasColumn('machineries', 'machinery_working_nature_id')) {
                Schema::table('machineries', function (Blueprint $table) {
                    $table->foreignId('machinery_working_nature_id')->constrained('machinery_working_natures');
                });
            }
        }

        if (Schema::hasTable('machinery_categories')) {
            if (!Schema::hasColumn('machinery_categories', 'machinery_working_nature_id')) {
                Schema::table('machinery_categories', function (Blueprint $table) {
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


        if (Schema::hasTable('machinery_categories')) {
            if (Schema::hasColumn('machinery_categories', 'machinery_working_nature_id')) {
                Schema::table('machinery_categories', function (Blueprint $table) {
                    $table->dropForeign(['machinery_working_nature_id']);
                    $table->dropColumn('machinery_working_nature_id');
                });
            }
        }

    }
};
