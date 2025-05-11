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
        Schema::table('secondhand_inventories', function (Blueprint $table) {
            $table->boolean('hot_sale')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('secondhand_inventories')) {
            if (Schema::hasColumn('secondhand_inventories', '')) {
                Schema::table('secondhand_inventories', function (Blueprint $table) {
                    $table->dropColumn('hot_sale');
                });
            }
        }
    }
};
