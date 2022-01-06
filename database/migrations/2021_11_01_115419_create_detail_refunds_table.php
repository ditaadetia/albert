<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refund_id');
            $table->foreignId('equipment_id');
            $table->integer('jumlah_hari_refund')->nullable;
            $table->integer('jumlah_jam_refund')->nullable;
            $table->string('alasan')->nullable;
            $table->enum('ket_verif_admin', ['belum', 'verif', 'tolak'])->nullable;
            $table->enum('ket_persetujuan_kepala_uptd', ['belum', 'setuju', 'tolak'])->nullable;
            $table->enum('ket_persetujuan_kepala_dinas', ['belum', 'setuju', 'tolak'])->nullable;
            $table->string('ket_konfirmasi')->nullable;
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
        Schema::dropIfExists('detail_refunds');
    }
}
