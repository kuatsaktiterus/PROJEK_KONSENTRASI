<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kelas',
        'id_jurusan',
        'status'
    ];

    public function PembagianKelas()
    {
        return $this->hasMany('App\Models\PembagianKelas', 'id_kelas');
    }

    public function Jurusan()
    {
        return $this->belongsTo('App\Models\Jurusan', 'id_jurusan');
    }
}
