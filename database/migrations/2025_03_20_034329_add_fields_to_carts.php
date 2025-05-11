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
        Schema::table('carts', function (Blueprint $table) {
            $table->bigInteger('amount')->after('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('carts')) {
            if (Schema::hasColumn('carts', 'amount')) {
                Schema::table('carts', function (Blueprint $table) {
                    $table->dropColumn('amount');
                });
            }
        }
    }
};
