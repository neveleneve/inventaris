<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_inventarisasi');
            $table->integer('tahun_pengadaan');
            $table->enum('jenis_inventarisasi', ['masuk', 'keluar']);
            $table->dateTime('verified_at')->default(null)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('inventaris');
    }
};
