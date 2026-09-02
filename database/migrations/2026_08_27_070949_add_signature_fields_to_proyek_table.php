<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proyek', function (Blueprint $table) {
            $table->string('nama_tim_uji_terima')->nullable();
            $table->string('nik_tim_uji_terima')->nullable();
            $table->string('ttd_tim_uji_terima')->nullable(); // path file gambar tanda tangan

            $table->string('nama_pelaksana_ttd')->nullable();
            $table->string('nik_pelaksana_ttd')->nullable();
            $table->string('ttd_pelaksana')->nullable(); // path file gambar tanda tangan
        });
    }

    public function down(): void
    {
        Schema::table('proyek', function (Blueprint $table) {
            $table->dropColumn([
                'nama_tim_uji_terima',
                'nik_tim_uji_terima',
                'ttd_tim_uji_terima',
                'nama_pelaksana_ttd',
                'nik_pelaksana_ttd',
                'ttd_pelaksana',
            ]);
        });
    }
};
