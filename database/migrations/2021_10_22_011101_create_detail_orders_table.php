<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->default();
            $table->foreignId('equipment_id')->default();
            $table->dateTime('tanggal_ambil')->nullable();
            $table->dateTime('tanggal_kembali')->nullable();
            $table->enum('status', ['Selesai', 'Sedang Dipakai', 'Belum Diambil'])->default('Belum Diambil');
            $table->boolean('pembatalan')->default(0);
            $table->boolean('konfirmasi_denda')->default(0);
            $table->string('alasan')->nullable();
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
        Schema::dropIfExists('detail_orders');
    }
}
