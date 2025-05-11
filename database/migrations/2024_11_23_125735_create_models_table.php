<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected array $subTables = [
        'network',
        'body',
        'display',
        'platform',
        'memory',
        'main_camera',
        'selfie_camera',
        'sound',
        'communication',
        'feature',
        'battery',
        'test_results',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
            $table->string('model_no')->unique();
            $table->string('slug')->unique();
            $table->foreignId('brand_id')->constrained('brands');
            $table->longText('description');
            $table->longText('specifications');
            $table->date('released')->nullable();
            $table->string('thumbnail');
            $table->json('attachments')->nullable();
            $table->boolean('hot_sale')->default(false);
            $table->boolean('new')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(false);
            $table->timestamps();

            $table->index('model_no','slug');
        });

        foreach ($this->subTables as $subTable) {
        Schema::table('models',function (Blueprint $table) use ($subTable){
            $table->boolean($subTable.'_active')->default(false);
            $table->string($subTable.'_specification')->nullable();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (array_reverse($this->subTables) as $tableName) {
            Schema::dropIfExists($tableName);
        }

        Schema::dropIfExists('models');
    }
};
