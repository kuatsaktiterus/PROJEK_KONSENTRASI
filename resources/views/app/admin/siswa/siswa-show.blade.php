@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
            <li class="breadcrumb-item active">Tampilkan Data Siswa</li>
            
        </ol>
    </nav>

    <div class="float-right">
        <a href="{{ route('siswa.edit', ['siswa' => Crypt::encrypt($siswa->id)]) }}" class="waves btn btn-primary">
            <i class="fas fa-pen-square" style="color:white;"></i>
        </a>
    </div>
    <div class="row no-gutters ml-2 mb-2 mr-2">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <img src="{{asset("storage/image/siswa/" . $siswa->foto)}}" alt="" width=70%>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <dl class="row">
                <dt class="col-sm-5">Nama</dt>
                <dd class="col-sm-7">{{ $siswa->name }}</dd>

                <dt class="col-sm-5">Jenis Kelamin</dt>
                <dd class="col-sm-7">{{ $siswa->jenis_kelamin }}</dd>

                <dt class="col-sm-5">NISN</dt>
                <dd class="col-sm-7">{{ $siswa->nisn }}</dd>

                <dt class="col-sm-5">NIK</dt>
                <dd class="col-sm-7">{{ $siswa->nik }}</dd>

                <dt class="col-sm-5">Jurusan</dt>
                <dd class="col-sm-7">{{ $siswa->jurusan->jurusan }}</dd>

                <dt class="col-sm-5">Tempat Lahir</dt>
                <dd class="col-sm-7">{{ $siswa->tempat_lahir }}</dd>

                <dt class="col-sm-5">Tanggal Lahir</dt>
                <dd class="col-sm-7">{{ $siswa->tanggal_lahir }}</dd>

                <dt class="col-sm-5">Agama</dt>
                <dd class="col-sm-7">{{ $siswa->agama }}</dd>

                <dt class="col-sm-5">No. HP</dt>
                <dd class="col-sm-7">{{ $siswa->no_telepon }}</dd>

                <dt class="col-sm-5">Alamat Lengkap</dt>
                <dd class="col-sm-7">
                    <p>
                        {{ $siswa->alamat_lengkap }}
                    </p>
                </dd>
                
                <dt class="col-sm-5">Alamat RT</dt>
                <dd class="col-sm-7">{{ $siswa->alamat_rt }}</dd>

                <dt class="col-sm-5">Alamat RW</dt>
                <dd class="col-sm-7">{{ $siswa->alamat_rw }}</dd>

                <dt class="col-sm-5">Alamat Kelurahan</dt>
                <dd class="col-sm-7">{{ $siswa->alamat_kelurahan }}</dd>

                <dt class="col-sm-5">Alamat Kecamatan</dt>
                <dd class="col-sm-7">{{ $siswa->alamat_kecamatan }}</dd>

                <dt class="col-sm-5">Tinggal Bersama</dt>
                <dd class="col-sm-7">{{ $siswa->tinggal_bersama }}</dd>

                <dt class="col-sm-5">Transportasi</dt>
                <dd class="col-sm-7">{{ $siswa->transportasi }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection