<?php

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\PembagianKelas;
use App\Models\Siswa;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembagianKelasSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembagian_kelas_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Siswa::class, 'id_siswa');
            $table->foreignIdFor(PembagianKelas::class, 'id_pembagian_kelas');

            // relation
            $table->index('id_siswa');
            $table->index('id_pembagian_kelas');

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
        Schema::dropIfExists('pembagian_kelas_siswas');
    }
}
