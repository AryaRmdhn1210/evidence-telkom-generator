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
    Schema::create('foto_bukti', function (Blueprint $table) {
      $table->id();

      $table->foreignId('item_proyek_id')
        ->constrained('item_proyek')
        ->cascadeOnDelete();

      $table->string('file_path');

      // Dipakai untuk generate keterangan otomatis, misal "1:4-Spliter (1)", "(2)", dst
      $table->unsignedInteger('nomor_urut');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('foto_bukti');
  }
};
