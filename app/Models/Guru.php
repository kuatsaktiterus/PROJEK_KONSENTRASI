<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nip',
        'golongan',
        'nama',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'pendidikan_terakhir',
        'jurusan_pendidikan',
        'foto',
        'id_user',
    ];
    
    public function User()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function PembagianKelas()
    {
        return $this->hasMany('App\Models\PembagianKelas', 'wali_kelas');
    }

    public function JadwalKelas()
    {
        return $this->hasMany('App\Models\JadwalKelas', 'id_pengajar');
    }

    public function isWaliKelas($id)
    {
        $isWaliKelas = PembagianKelas::where('wali_kelas', $id);
        return ($isWaliKelas) ? true : false;
    }
}

        