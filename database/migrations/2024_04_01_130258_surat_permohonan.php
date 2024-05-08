<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuratPermohonan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_pc', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pencipta')->nullable();
            $table->string('wn_pencipta')->nullable();
            $table->string('alamat_pencipta')->nullable();
            $table->string('email_pencipta')->nullable();
            $table->string('no_hp_pencipta')->nullable();
            $table->string('nama_pg_hak')->nullable();
            $table->string('wn_pg_hak')->nullable();
            $table->string('alamat_pg_hak')->nullable();
            $table->string('email_pg_hak')->nullable();
            $table->string('jenis_cipta')->nullable();
            $table->string('tgl_tempat')->nullable();
            $table->text('uraian_cipta')->nullable();
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
        Schema::dropIfExists('dokumen_pc');
    }
}
