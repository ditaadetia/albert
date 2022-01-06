<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKeluarMasukAlatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_keluar_masuk_alats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable;
            $table->foreignId('equipment_id')->nullable;
            $table->dateTime('tanggal_ambil')->nullable;
            $table->dateTime('tanggal_kembali')->nullable;
            $table->enum('status', ['Selesai', 'Sedang Dipakai', 'Belum Diambil'])->nullable;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_keluar_masuk_alats');
    }
}
