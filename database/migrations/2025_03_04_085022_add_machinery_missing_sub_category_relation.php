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
        Schema::table('machineries',function (Blueprint $table){
            $table->unsignedBigInteger('machinery_sub_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('machineries')){
            if(Schema::hasColumn('machineries', 'machinery_sub_category_id')){
                Schema::table('machineries',function (Blueprint $table){
                    $table->dropColumn('machinery_sub_category_id');
                });
            }
        }
    }
};
