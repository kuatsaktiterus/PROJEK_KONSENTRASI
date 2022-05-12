@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('jurusan.index') }}"> Jurusan</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('kelas.show', ['kela' => Crypt::encrypt($jurusan->id)] )}}"> Pembagian Kelas Jurusan {{$jurusan->jurusan}}</a></li>
            <li class="breadcrumb-item"><a href="/app/pembagian-kelas/{{Crypt::encrypt($id)}}"> Kelas {{$kelas}} Jurusan {{$jurusan->jurusan}}</a></li>
            <li class="breadcrumb-item active">Pembagian Kelas {{$kelas}} {{$jurusan->jurusan}}</li>
        </ol>
    </nav>

    <div class="mt-1 mb-3 button-container">
        <a class="btn btn-primary" href="{{ route("pembagian-kelas-siswa.edit", ['pembagian_kelas_siswa' => Crypt::encrypt($idPembagianKelas)]) }}" style="color:white !important;">
            Isi kelas</a>
        <a class="btn btn btn-primary" href="{{ route("jadwal-kelas.show", ['jadwal_kela' => Crypt::encrypt($idPembagianKelas)]) }}"
            onclick="event.preventDefault();
            document.getElementById('jadwalkelas-form').submit();"
            style="color:white !important;">
            Jadwal Kelas
        </a>
        <form id="jadwalkelas-form" action="/app/jadwal-kelas/{{Crypt::encrypt($idPembagianKelas)}}"  method="GET" class="d-none">
        </form>
    </div>
    <div><br>
        <p>Banyak siswa di kelas ini = {{$banyakSiswa}}</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                <div class="table-responsive">
                {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
        {!! $dataTable->scripts() !!}
    </div>
    <div id="result"></div>
</div>
@endsection