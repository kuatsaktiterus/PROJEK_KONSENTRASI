<?php

use App\Models\ArsipRekapitulasiKelas;
use App\Models\PembagianKelas;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapitulasiKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PembagianKelas::class, "id_pembagian_kelas");
            $table->foreignIdFor(ArsipRekapitulasiKelas::class, "id_arsip_rekapitulasi_kelas");
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
        Schema::dropIfExists('rekapitulasi_kelas');
    }
}
