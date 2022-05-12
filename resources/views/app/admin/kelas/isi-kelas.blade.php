@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('jurusan.index') }}"> Jurusan</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('kelas.show', ['kela' => Crypt::encrypt($pembagianKelas->kelas->jurusan->id)] )}}"> Pembagian Kelas Jurusan {{$pembagianKelas->kelas->jurusan->jurusan}}</a></li>
            <li class="breadcrumb-item"><a href="/app/pembagian-kelas/{{Crypt::encrypt($pembagianKelas->id_kelas)}}"> Kelas {{$pembagianKelas->kelas->kelas}} Jurusan {{$pembagianKelas->kelas->jurusan->jurusan}}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pembagian-kelas-siswa.show', ['pembagian_kelas_siswa' => Crypt::encrypt($pembagianKelas->id)]) }}"> Pembagian Kelas</a>  {{$pembagianKelas->kelas->kelas}} {{$pembagianKelas->kelas->jurusan->jurusan}}</li> 
            <li class="breadcrumb-item active">Kelas {{$pembagianKelas->kelas->kelas}} {{$pembagianKelas->nama_kelas}} Jurusan {{$pembagianKelas->kelas->jurusan->jurusan}}</li> 
        </ol>
    </nav>

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