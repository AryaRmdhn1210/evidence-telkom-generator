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
    Schema::create('item_pekerjaan', function (Blueprint $table) {
      $table->id();

      $table->string('kode_designator')->unique();
      $table->string('uraian_pekerjaan');
      $table->string('satuan');

      // Saran default kategori foto, tetap bisa dioverride manual saat input di item_proyek
      $table->enum('kategori_foto_default', ['representatif', 'wajib_per_unit'])->nullable();

      // false jika item ditambahkan manual oleh tim kantor, di luar master data resmi Excel
      $table->boolean('is_master')->default(true);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('item_pekerjaan');
  }
};
