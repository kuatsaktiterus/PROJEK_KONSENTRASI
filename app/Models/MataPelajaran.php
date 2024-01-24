<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = [
        'nama_mapel',
        'deskripsi_predikat_A',
        'deskripsi_predikat_B',
        'deskripsi_predikat_C',
        'deskripsi_predikat_D',
        'semester',
        'kkm',
	];

    public function JadwalKelas()
    {
        return $this->hasMany(JadwalKelas::class, 'id_matapelajaran');
    }
}
