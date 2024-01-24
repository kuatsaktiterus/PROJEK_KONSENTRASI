@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Nilai dan semester</li>
        </ol>
    </nav>

    <center>
        <div class="mt-1 mb-3 button-container col-md-12">
            <div class="row pl-0">
                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="bg-white border shadow">
                        <div class="media p-4">
                            <div class="media-body pl-2">
                                @if ($tahunAjar->aktif)
                                    <h3 class="mt-0 mb-0">Semester Aktif</h3>
                                    <p><small class="text-muted bc-description">Semester {{$tahunAjar->semester}}</small></p>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#akhiriSemester" data-whatever="@mdo">
                                        Akhiri Semester
                                    </button>
                                @else
                                    <h3 class="mt-0 mb-0">Semester Non-Aktif</h3>
                                    <p><small class="text-muted bc-description">Semester selanjutnya : @if($tahunAjar->semester == 'genap') Ganjil @else Genap @endif</small></p>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#mulaiSemester" data-whatever="@mdo">
                                        Mulai Semester
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                    <div class="bg-white border shadow">
                        <div class="media p-4">
                            <div class="media-body pl-2">
                                <h3 class="mt-0 mb-0">Data Raport</h3>
                                <p><small class="text-muted bc-description">Data Raport Seluruh Siswa</small></p>
                                <form action="{{ route('nilai-semester-siswa.index') }}" method="get">
                                    <button class="btn btn-success" >
                                        Lihat Data
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </center>

    @if ($tahunAjar->aktif)
    <h2>Data Kelas</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white p-4" style="border-radius:3px;box-shadow:rgba(0, 0, 0, 0.03) 0px 4px 8px 0px">
                <div class="table-responsive">
                    <table class="table" style="margin-top: -10px;">
                        <tr>
                            <td>Seluruh Kelas</td>
                            <td>:</td>
                            <td>{{ $jumlahPembagianKelas }}</td>
                        </tr>
                        <tr>
                            <td>Kelas Terekapitulasi</td>
                            <td>:</td>
                            <td>{{ $jumlahKelasTerekapitulasi->count() }}</td>
                        </tr>
                        <tr>
                            <td>Kelas Belum Terekapitulasi</td>
                            <td>:</td>
                            <td>{{ $jumlahPembagianKelas -  $jumlahKelasTerekapitulasi->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>    
        </div>
    </div>
    @endif
</div>

@if ($tahunAjar->aktif)
<div class="modal fade bd-example-modal-lg" id="akhiriSemester" tabindex="-1" role="dialog" aria-labelledby="akhiriSemester" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="akhiriSemester">Akhiri Semester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('nilai-semester.update', ['id_arsip' => Crypt::encrypt($idArsip), 'id_tahun_ajar' => Crypt::encrypt($tahunAjar->id)]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            @if ($jumlahPembagianKelas -  $jumlahKelasTerekapitulasi->count() == 0)
                <div class="modal-body">
                    <p class="text-center text-danger">
                        Raport akan di rekap dan tidak akan bisa di rubah lagi, anda yakin mengakhiri semester?
                    </p>
                </div>
            @else
                <div class="modal-body">
                    <p class="text-center text-danger">
                        Masih ada kelas yang belum mengkonfirmasi, 
                        raport akan di rekap dan tidak akan bisa di rubah lagi, anda yakin mengakhiri semester?
                    </p>
                </div>
            @endif
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </form>
    </div>
    </div>
</div>
@else
<div class="modal fade bd-example-modal-lg" id="mulaiSemester" tabindex="-1" role="dialog" aria-labelledby="mulaiSemester" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="mulaiSemester">Mulai Semester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('nilai-semester.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="modal-body">
                <p class="text-center">
                    Ingin memulai semester, anda yakin?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    </div>
</div>
@endif
@endsection