<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembagianKelas extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_kelas',
        'nama_kelas',
        'wali_kelas',
    ];
    
    public function JadwalKelas()
    {
        return $this->hasMany('App\Models\JadwalKelas', 'id_pembagian_kelas');
    }

    public function Guru()
    {
        return $this->belongsTo('App\Models\Guru', 'wali_kelas');
    }

    public function Kelas()
    {
        return $this->belongsTo('App\Models\Kelas', 'id_kelas');
    }

    public function Jurusan()
    {
        return $this->belongsTo('App\Models\Jurusan', 'id_jurusan');
    }
    
    public function PembagianKelasSiswa()
    {
        return $this->hasMany('App\Models\PembagianKelasSiswa', 'id_pembagian_kelas');
    }
}
