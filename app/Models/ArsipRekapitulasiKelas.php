<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipRekapitulasiKelas extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kelas_aktif',
        'kelas_terekapitulasi',
        'kelas_belum_terekapitulasi',
        'id_tahun_ajaran'
    ];

    public function RekapitulasiKelas()
    {
        return $this->hasMany(RekapitulasiKelas::class, 'id_arsip_rekapitulasi_kelas');
    }
    
    public function TahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_tahun_ajaran');
    }

    public function Raport()
    {
        return $this->hasMany(Raport::class, 'id_arsip_rekapitulasi_kelas');
    }
}
