<?php

use App\Models\TahunAjaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipRekapitulasiKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_rekapitulasi_kelas', function (Blueprint $table) {
            $table->id();
            $table->integer("kelas_aktif");
            $table->integer('kelas_terekapitulasi');
            $table->integer('kelas_belum_terekapitulasi');
            $table->foreignIdFor(TahunAjaran::class, "id_tahun_ajaran");
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
        Schema::dropIfExists('arsip_rekapitulasi_kelas');
    }
}
