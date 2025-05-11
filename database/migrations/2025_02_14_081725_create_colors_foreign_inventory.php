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
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreignId('color_id')->constrained('colors');
        });
        Schema::table('secondhand_inventories', function (Blueprint $table) {
            $table->foreignId('color_id')->constrained('colors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('inventories')) {
            Schema::table('inventories', function (Blueprint $table) {
                if (Schema::hasColumn('inventories', 'color_id')) {
                    $table->dropForeign(['color_id']);
                    $table->dropColumn('color_id');
                }
            });
        }

        if (Schema::hasTable('secondhand_inventories')) {
            Schema::table('secondhand_inventories', function (Blueprint $table) {
                if (Schema::hasColumn('secondhand_inventories', 'color_id')) {
                    $table->dropForeign(['color_id']);
                    $table->dropColumn('color_id');
                }
            });
        }
    }
};
