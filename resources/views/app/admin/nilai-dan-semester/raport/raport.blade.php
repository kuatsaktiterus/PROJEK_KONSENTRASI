@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')

@inject('kelas', 'App\Models\Siswa')
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('nilai-semester.index') }}">Nilai dan semester</a> </li>
        <li class="breadcrumb-item"><a href="{{ route('nilai-semester-siswa.index') }}">Siswa</a></li>
        <li class="breadcrumb-item"><a href="{{ route('nilai-semester-list-raport.index', ['id' => Crypt::encrypt($raport->siswa->id)]) }}">List Raport</a></li>
        <li class="breadcrumb-item active">Raport</li>
    </ol>
</nav>

<div class="card card-primary">
    <div class="card-header">
      <div class="card-title">
        <div>
            <h3>Raport {{$raport->siswa->name}}</h3>
        </div>

      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                    <div class="table-responsive">
                        <table class="table" style="margin-top: -10px;">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{$raport->siswa->name}}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>:</td>
                                <td>{{$raport->siswa->nisn}}</td>
                            </tr>
                            @if (!$kelas->isKelasNull($idSiswa))
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>{{$pembagianKelas->nama_kelas}}</td>
                                </tr>
                                <tr>
                                    <td>Wali Kelas</td>
                                    <td>:</td>
                                    <td>{{$pembagianKelas->guru->nama}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Semester</td>
                                <td>:</td>
                                <td>{{Str::ucfirst($raport->ArsipRekapitulasiKelas->TahunAjaran->semester)}}</td>
                            </tr>
                            <tr>
                                <td>Tahun Pelajaran</td>
                                <td>:</td>
                                <td>{{$raport->ArsipRekapitulasiKelas->TahunAjaran->tahun_ajar_awal . "/" . $raport->ArsipRekapitulasiKelas->TahunAjaran->tahun_ajar_akhir}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Mapel</th>
                            <th class="ctr" colspan="3">Pengetahuan</th>
                            <th class="ctr" colspan="3">Keterampilan</th>
                        </tr>
                        <tr>
                            <th class="ctr">Nilai</th>
                            <th class="ctr">Predikat</th>
                            <th class="ctr">Deskripsi</th>
                            <th class="ctr">Nilai</th>
                            <th class="ctr">Predikat</th>
                            <th class="ctr">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($raportMataPelajaran as $rmp)
                            <tr>
                                <td class="ctr">
                                    <div class="text-center">{{$rmp->mata_pelajaran}}</div>
                                </td>
                                <td class="ctr">
                                    <div class="text-center">{{$rmp->nilai_pengetahuan}}</div>
                                </td>
                                <td class="ctr">
                                    <div class="text-center">{{$rmp->predikat_pengetahuan}}</div>
                                </td>
                                <td class="ctr">
                                    <textarea class="form-control " cols="50" rows="5" disabled>{{$rmp->deskripsi_pengetahuan}}</textarea>
                                </td>
                                <td class="ctr">
                                    <div class="text-center">{{$rmp->nilai_keterampilan}}</div>
                                </td>
                                <td class="ctr">
                                    <div class="text-center">{{$rmp->predikat_keterampilan}}</div>
                                </td>
                                <td class="ctr">
                                    <textarea class="form-control" cols="50" rows="5" disabled>{{$rmp->deskripsi_keterampilan}}</textarea>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>


</div>
@endsection