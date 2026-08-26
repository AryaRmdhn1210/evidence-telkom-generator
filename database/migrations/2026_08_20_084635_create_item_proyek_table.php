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
    Schema::create('item_proyek', function (Blueprint $table) {
      $table->id();

      $table->foreignId('proyek_id')
        ->constrained('proyek')
        ->cascadeOnDelete();

      $table->foreignId('item_pekerjaan_id')
        ->constrained('item_pekerjaan')
        ->cascadeOnDelete();

      // Quantity, semua manual sesuai kolom di Excel BOQ UT
      $table->unsignedInteger('qty_drm')->default(0);
      $table->unsignedInteger('qty_rekon_aktual')->default(0);
      $table->unsignedInteger('qty_tambah')->default(0);
      $table->unsignedInteger('qty_kurang')->default(0);

      // Dipilih manual oleh tim kantor saat input, bukan otomatis dari master data
      $table->enum('kategori_foto', ['representatif', 'wajib_per_unit'])
        ->default('wajib_per_unit');

      // Urutan item dalam proyek, dipakai untuk penomoran otomatis di keterangan foto
      $table->unsignedInteger('urutan_item')->default(1);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('item_proyek');
  }
};
