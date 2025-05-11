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
        Schema::table('models', function (Blueprint $table) {
            if (!Schema::hasColumn('models', 'slug')) {
                $table->string('slug')->unique()->after('model_no');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('models')) {
            Schema::table('models', function (Blueprint $table) {
                if(Schema::hasColumn('models', 'slug')) {
                    $table->dropColumn('slug');
                }
            });
        }
    }

};
