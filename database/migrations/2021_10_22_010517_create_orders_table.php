<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->default();
            $table->foreignId('category_order_id')->default();
            $table->string('nama_instansi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('alamat_instansi')->nullable();
            $table->string('nama_kegiatan')->default('');
            $table->string('surat_permohonan')->default('');
            $table->longText('ttd_pemohon')->default('');
            $table->string('ktp')->default('');
            $table->string('akta_notaris')->nullable();
            $table->string('surat_ket')->nullable();
            $table->enum('ket_verif_admin', ['belum', 'verif', 'tolak'])->default('belum');
            $table->enum('ket_persetujuan_kepala_uptd', ['belum', 'setuju', 'tolak'])->default('belum');
            $table->enum('ket_persetujuan_kepala_dinas', ['belum', 'setuju', 'tolak'])->default('belum');
            $table->string('ttd_kepala_uptd')->default('');
            $table->string('ttd_kepala_dinas')->default('');
            $table->string('ket_konfirmasi')->default('');
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('dokumen_sewa')->default('');
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
        Schema::dropIfExists('orders');
    }
}
