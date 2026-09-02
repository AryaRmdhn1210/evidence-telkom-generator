<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->foreignId('proyek_id')->after('id')->constrained('proyek')->cascadeOnDelete();
            $table->foreignId('dibuat_oleh')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_uji_terima');
            $table->string('file_pdf')->nullable();
            $table->string('file_word')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['proyek_id']);
            $table->dropForeign(['dibuat_oleh']);
            $table->dropColumn(['proyek_id', 'dibuat_oleh', 'tanggal_uji_terima', 'file_pdf', 'file_word']);
        });
    }
};
