<?php

use App\Models\Raport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaportMataPelajaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raport_mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->string('wali_kelas');
            $table->string('mata_pelajaran');
            $table->integer('nilai_pengetahuan');
            $table->char('predikat_pengetahuan', 1);
            $table->string('deskripsi_pengetahuan');
            $table->integer('nilai_keterampilan')->nullable();
            $table->char('predikat_keterampilan', 1)->nullable();
            $table->string('deskripsi_keterampilan')->nullable();
            $table->boolean('submit')->default(false);
            $table->foreignIdFor(Raport::class, 'id_raport');
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
        Schema::dropIfExists('raport_mata_pelajarans');
    }
}
