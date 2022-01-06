<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->default('');
            $table->string('foto')->default('');
            $table->string('email')->default('');
            $table->timestamp('email_verified_at');
            $table->string('username')->default('');
            $table->string('password')->default('');
            $table->string('no_hp')->default('');
            $table->string('kontak_darurat')->default('');
            $table->string('alamat')->default('');
            $table->string('status')->default('aktif');
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
        Schema::dropIfExists('tenants');
    }
}
