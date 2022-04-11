<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jurusan',
    ];


    public function Siswa()
    {
        return $this->hasMany('App\Models\Siswa', 'id_jurusan');
    }

    public function Kelas()
    {
        return $this->hasMany('App\Models\Kelas', 'id_jurusan');
    }
}
