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
            $table->string('thumbnail')->after('model_id');
            $table->json('attachments')->after('thumbnail');
            $table->boolean('published')->default(false)->after('attachments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('parts')){
            Schema::table('parts', function (Blueprint $table) {
                if(Schema::hasColumn('parts', 'thumbnail')){
                    $table->dropColumn('thumbnail');
                }
                if(Schema::hasColumn('parts', 'attachments')){
                    $table->dropColumn('attachments');
                }
                if(Schema::hasColumn('parts', 'published')){
                    $table->dropColumn('published');
                }
            });
        }
    }
};
