<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('tenant_id');
            // $table->foreignId('detail_order_id')->default();
            // $table->string('surat_permohonan_refund')->nullable;
            $table->string('metode_refund')->nullable;
            $table->string('no_rekening')->nullable;
            $table->string('nama_penerima')->nullable;
            $table->enum('ket_verif_admin', ['belum', 'verif', 'tolak'])->default('belum');
            $table->enum('ket_persetujuan_kepala_uptd', ['belum', 'setuju', 'tolak'])->default('belum');
            $table->enum('ket_persetujuan_kepala_dinas', ['belum', 'setuju', 'tolak'])->default('belum');
            $table->boolean('refund_bendahara')->default(0);
            $table->string('bukti_refund')->default('');
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
        Schema::dropIfExists('refunds');
    }
}
