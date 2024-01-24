<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaportMataPelajaran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_kelas',
        'wali_kelas',
        'mata_pelajaran',
        'nilai_pengetahuan',
        'predikat_pengetahuan',
        'deskripsi_pengetahuan',
        'nilai_keterampilan',
        'predikat_keterampilan',
        'deskripsi_keterampilan',
        'submit',
        'id_raport',
    ];

    public function Raport()
    {
        return $this->belongsTo(Raport::class, 'id_raport');
    }
}
