<?php

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\PembagianKelas;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PembagianKelas::class, 'id_pembagian_Kelas');
            $table->foreignIdFor(MataPelajaran::class, 'id_matapelajaran');
            $table->foreignIdFor(Guru::class, 'id_pengajar');
            $table->foreignIdFor(Jadwal::class, 'id_jadwal');

            // relation
            $table->index('id_pembagian_kelas');
            $table->index('id_matapelajaran');
            $table->index('id_pengajar');
            $table->index('id_jadwal');
            
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
        Schema::dropIfExists('jadwal_kelas');
    }
}
