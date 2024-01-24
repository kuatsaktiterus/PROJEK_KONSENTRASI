<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_siswa',
        'id_arsip_rekapitulasi_kelas',
    ];

    public function RaportMataPelajaran()
    {
        return $this->hasMany(RaportMataPelajaran::class, 'id_raport');
    }

    public function ArsipRekapitulasiKelas()
    {
        return $this->belongsTo(ArsipRekapitulasiKelas::class, 'id_arsip_rekapitulasi_kelas');
    }

    public function Siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
}
