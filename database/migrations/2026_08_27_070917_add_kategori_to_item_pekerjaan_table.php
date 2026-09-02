<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('item_pekerjaan', function (Blueprint $table) {
            $table->string('kategori_pekerjaan')->nullable()->after('uraian_pekerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('item_pekerjaan', function (Blueprint $table) {
            $table->dropColumn('kategori_pekerjaan');
        });
    }
};
