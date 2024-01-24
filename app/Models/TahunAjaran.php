<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tahun_ajar_awal',
        'tahun_ajar_akhir',
        'semester',
        'aktif'
    ];

    public function ArsipRekapitulasiKelas()
    {
        return $this->hasOne(ArsipRekapitulasiKelas::class, 'id_tahun_ajaran');
    }
}
