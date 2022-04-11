<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembagianKelasSiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_siswa',
        'id_pembagian_kelas'
    ];

    public function Siswa()
    {
        return $this->belongsTo('App\Models\Siswa', 'id_siswa');
    }

    public function JadwalKelas()
    {
        return $this->hasMany('App\Models\JadwalKelas', 'id_pembagian_kelas');
    }

    public function PembagianKelas()
    {
        return $this->belongsTo('App\Models\PembagianKelas', 'id_pembagian_kelas');
    }
}
