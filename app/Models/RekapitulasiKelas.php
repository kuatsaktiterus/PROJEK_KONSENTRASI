<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapitulasiKelas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pembagian_kelas',
        'id_arsip_rekapitulasi_kelas',
    ];

    public function ArsipRekapitulasiKelas()
    {
        return $this->belongsTo(ArsipRekapitulasiKelas::class, 'id_arsip_rekapitulasi_kelas');
    }

    public function PembagianKelas()
    {
        return $this->belongsTo(PembagianKelas::class, 'id_pembagian_kelas');
    }
}
