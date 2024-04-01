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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('perusahaan');
            $table->string('alamat');
            $table->string('kuasaalamat');
            $table->string('telepon');
            $table->string('email');
            $table->string('lisensi');
            $table->string('pemilik_Hak');
            $table->string('penerima_Hak');
            $table->date('sejak_tanggal');
            $table->date('sampai_tanggal');
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
        Schema::dropIfExists('permohonan');
    }
}
