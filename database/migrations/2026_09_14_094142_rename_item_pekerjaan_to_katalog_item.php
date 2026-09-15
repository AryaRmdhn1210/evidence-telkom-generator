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
        Schema::rename('item_pekerjaan', 'katalog_item');

        Schema::table('item_proyek', function (Blueprint $table) {
            $table->dropForeign(['item_pekerjaan_id']);
        });

        Schema::table('item_proyek', function (Blueprint $table) {
            $table->renameColumn('item_pekerjaan_id', 'katalog_item_id');
        });

        Schema::table('item_proyek', function (Blueprint $table) {
            $table->foreign('katalog_item_id')
                ->references('id')
                ->on('katalog_item')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_proyek', function (Blueprint $table) {
            $table->dropForeign(['katalog_item_id']);
        });

        Schema::table('item_proyek', function (Blueprint $table) {
            $table->renameColumn('katalog_item_id', 'item_pekerjaan_id');
        });

        Schema::table('item_proyek', function (Blueprint $table) {
            $table->foreign('item_pekerjaan_id')
                ->references('id')
                ->on('item_pekerjaan')
                ->cascadeOnDelete();
        });

        Schema::rename('katalog_item', 'item_pekerjaan');
    }
};
