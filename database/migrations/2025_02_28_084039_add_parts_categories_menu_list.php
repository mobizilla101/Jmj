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
        Schema::table('parts_categories', function (Blueprint $table): void {
            $table->string('parts_category')->nullable()->after('name')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('parts_categories')){
            if(Schema::hasColumn('parts_categories', 'parts_category')){
                Schema::table('parts_categories', function (Blueprint $table): void {
                    $table->dropColumn('parts_category');
                });
            }
        }
    }
};
