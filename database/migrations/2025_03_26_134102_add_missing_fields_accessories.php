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
        Schema::table('accessories', function (Blueprint $table) {
            $table->string('slug')->after('title');
            $table->boolean('hot_sale')->default(false)->after('amount');
            $table->boolean('new')->default(false)->after('hot_sale');
            $table->boolean('published')->default(false)->after('new');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('accessories')){
            if(Schema::hasColumn('accessories', 'slug')){
                Schema::table('accessories', function (Blueprint $table) {
                    $table->dropColumn('slug');
                });
            }
            if(Schema::hasColumn('accessories', 'hot_sale')){
                Schema::table('accessories', function (Blueprint $table) {
                    $table->dropColumn('hot_sale');
                });
            }
            if(Schema::hasColumn('accessories', 'new')){
                Schema::table('accessories', function (Blueprint $table) {
                    $table->dropColumn('new');
                });
            }
            if(Schema::hasColumn('accessories', 'published')){
                Schema::table('accessories', function (Blueprint $table) {
                    $table->dropColumn('published');
                });
            }
        }
    }
};
