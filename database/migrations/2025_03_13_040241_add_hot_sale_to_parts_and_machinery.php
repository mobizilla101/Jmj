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
        Schema::table('parts', function (Blueprint $table) {
            $table->boolean('hot_sale')->default(false);
        });

        Schema::table('machineries', function (Blueprint $table) {
            $table->boolean('hot_sale')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('parts')){
            if(Schema::hasColumn('parts', 'hot_sale')){
                Schema::table('parts', function (Blueprint $table) {
                    $table->dropColumn('hot_sale');
                });
            }
        }

        if(Schema::hasTable('machineries')){
            if(Schema::hasColumn('machineries', 'hot_sale')){
                Schema::table('machineries', function (Blueprint $table) {
                    $table->dropColumn('hot_sale');
                });
            }
        }
    }
};
