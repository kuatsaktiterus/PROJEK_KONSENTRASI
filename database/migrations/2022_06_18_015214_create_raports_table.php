<?php

use App\Models\ArsipRekapitulasiKelas;
use App\Models\Siswa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Siswa::class, 'id_siswa');
            $table->foreignIdFor(ArsipRekapitulasiKelas::class, 'id_arsip_rekapitulasi_kelas');
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
        Schema::dropIfExists('raports');
    }
}
