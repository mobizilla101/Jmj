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
        Schema::table('secondhand_inventories', function (Blueprint $table) {
            $table->string('thumbnail')->after('color_id');
            $table->json('attachments')->nullable()->after('thumbnail');
            $table->boolean('refurbed')->default(false)->after('attachments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('secondhand_inventories')) {
            Schema::table('secondhand_inventories', function (Blueprint $table) {
                // Drop the foreign key first before dropping the column
                if (Schema::hasColumn('secondhand_inventories', 'thumbnail')) {
                    $table->dropColumn('thumbnail');
                }
                if (Schema::hasColumn('secondhand_inventories', 'attachments')) {
                    $table->dropColumn('attachments');
                }

                if(Schema::hasColumn('secondhand_inventories', 'refurbed')) {
                    $table->dropColumn('refurbed');
                }
            });
        }
    }
};


