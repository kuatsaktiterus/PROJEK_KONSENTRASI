<?php

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembagianKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembagian_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->foreignIdFor(Guru::class, 'wali_kelas');
            $table->foreignIdFor(Kelas::class, 'id_kelas');

            $table->index('wali_kelas');
            $table->index('id_kelas');

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
        Schema::dropIfExists('pembagian_kelas');
    }
}
