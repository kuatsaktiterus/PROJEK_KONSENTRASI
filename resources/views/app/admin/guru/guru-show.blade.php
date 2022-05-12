@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
            <li class="breadcrumb-item active">Tampilkan Data Guru</li>
        </ol>
    </nav>

    <div class="float-right">
        <a href="{{ route('guru.edit', ['guru' => Crypt::encrypt($guru->id)]) }}" class="waves btn btn-primary">
            <i class="fas fa-pen-square" style="color:white;"></i>
        </a>
    </div>
    <div class="row no-gutters ml-2 mb-2 mr-2">
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <img src="{{asset("storage/image/guru/" . $guru->foto)}}" alt="" width=70%>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-5">
            <dl class="row">
                <dt class="col-sm-6">Nama</dt>
                <dd class="col-sm-6">{{ $guru->nama }}</dd>

                <dt class="col-sm-6">NIP</dt>
                <dd class="col-sm-6">{{ $guru->nip }}</dd>

                <dt class="col-sm-6">Golongan</dt>
                <dd class="col-sm-6">{{ $guru->golongan }}</dd>

                <dt class="col-sm-6">Jenis Kelamin</dt>
                <dd class="col-sm-6">{{ $guru->jenis_kelamin }}</dd>

                <dt class="col-sm-6">No. Telepon</dt>
                <dd class="col-sm-6">{{ $guru->no_telepon }}</dd>

                <dt class="col-sm-6">Pendidikan Terakhir</dt>
                <dd class="col-sm-6">{{ $guru->pendidikan_terakhir }}</dd>

                <dt class="col-sm-6">Jurusan Pendidikan</dt>
                <dd class="col-sm-6">{{ $guru->jurusan_pendidikan }}</dd>

                <dt class="col-sm-6">Alamat Lengkap</dt>
                <dd class="col-sm-6">
                    <p>
                        {{ $guru->alamat }}
                    </p>
                </dd>
            </dl>
        </div>
    </div>
</div>
@endsection