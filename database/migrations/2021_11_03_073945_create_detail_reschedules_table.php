<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailReschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_reschedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_order_id');
            $table->foreignId('order_id');
            $table->dateTime('waktu_mulai')->nullable;
            $table->dateTime('waktu_selesai')->nullable;
            $table->enum('ket_verif_admin', ['belum', 'verif', 'tolak'])->default('belum');
            $table->enum('ket_persetujuan_kepala_uptd', ['belum', 'setuju', 'tolak'])->default('belum');
            $table->string('keterangan')->default('');
            $table->string('alasan_refund')->default('');
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
        Schema::dropIfExists('detail_reschedules');
    }
}
