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
        if(Schema::hasTable('machinery_working_natures')) {
            if(Schema::hasColumn('machinery_working_natures', 'machinery_brand_id')) {

        Schema::table('machinery_working_natures', function (Blueprint $table) {
            $table->dropForeign(['machinery_brand_id']);
            $table->dropColumn('machinery_brand_id');
        });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
