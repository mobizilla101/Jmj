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
        Schema::table('why_choose_us', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('why_choose_us')) {

            Schema::table('why_choose_us', function (Blueprint $table) {
                if(Schema::hasColumn('why_choose_us','image')){
                    $table->dropColumn('image');
                }
            });
        }
    }
};
