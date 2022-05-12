<?php

use App\Models\Guru;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengumuman_gurus', function (Blueprint $table) {
            $table->id();
            $table->text('pengumuman');
            $table->date('waktu_pengumuman');
            
            $table->foreignIdFor(Guru::class, 'id_guru');          
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
        Schema::dropIfExists('pengumuman_gurus');
    }
}
