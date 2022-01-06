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
            $table->foreignId('reschedule_id');
            $table->foreignId('equipment_id');
            $table->dateTime('waktu_mulai')->nullable;
            $table->dateTime('waktu_selesai')->nullable;
            $table->enum('ket_verif_admin', ['belum', 'verif', 'tolak'])->nullable;
            $table->enum('ket_persetujuan_kepala_uptd', ['belum', 'setuju', 'tolak'])->nullable;
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
        Schema::dropIfExists('detail_reschedules');
    }
}
