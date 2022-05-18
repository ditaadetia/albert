<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('tenant_id');
            $table->string('metode_pembayaran')->default('');
            $table->string('kode_pembayaran')->default('');
            $table->string('bukti_pembayaran')->default('');
            $table->integer('total')->default(0);
            $table->boolean('konfirmasi_pembayaran')->default(0);
            $table->string('ket_konfirmasi')->default('');
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
        Schema::dropIfExists('payments');
    }
}
