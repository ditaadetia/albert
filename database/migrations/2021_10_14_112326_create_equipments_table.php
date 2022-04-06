<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->default('');
            $table->string('foto')->default('');
            $table->string('jenis')->default('');
            $table->string('kegunaan')->default('');
            $table->integer('total')->default();
            $table->integer('jumlah_tersedia')->default();
            $table->integer('harga_sewa_perjam')->default();
            $table->integer('harga_sewa_perhari')->default();
            $table->text('keterangan')->default('');
            $table->string('kondisi')->default('');
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
        Schema::dropIfExists('equipments');
    }
}
