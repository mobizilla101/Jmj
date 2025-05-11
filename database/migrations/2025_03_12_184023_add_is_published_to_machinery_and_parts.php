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
        Schema::table('machineries', function (Blueprint $table) {
            $table->boolean('published')->default(false)->after('id'); // Place it after 'id'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('machineries')){
            Schema::table('machineries', function (Blueprint $table) {
                if(Schema::hasColumn('machineries', 'published')){
                    $table->dropColumn('published');
                }
            });
        }
    }
};
