<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = [
        'tugas',
        'ulangan_harian',
        'uts',
        'uas',
        'keterampilan',
        'id_jadwal_kelas',
        'id_siswa',
        'id_guru'
	];

    public function JadwalKelas()
    {
        return $this->belongsTo(JadwalKelas::class, 'id_jadwal_kelas');
    }
}
