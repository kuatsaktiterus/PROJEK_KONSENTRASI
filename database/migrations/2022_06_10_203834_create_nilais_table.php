<?php

use App\Models\Guru;
use App\Models\JadwalKelas;
use App\Models\Siswa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->integer("tugas")->nullable();
            $table->integer("ulangan_harian")->nullable();
            $table->integer("uts")->nullable();
            $table->integer("uas")->nullable();
            $table->integer("keterampilan")->nullable();
            $table->foreignIdFor(JadwalKelas::class, 'id_jadwal_kelas');
            $table->foreignIdFor(Siswa::class, 'id_siswa');
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
        Schema::dropIfExists('nilais');
    }
}
