@extends('layouts.app')

@include('layouts.guru-layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('nilai-siswa.index') }}"> Mata Pelajaran</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('nilai-siswa.show', ['nilai_siswa' => Crypt::encrypt($mataPelajaran->id)]) }}">Pembagian Kelas </a> </li>
            <li class="breadcrumb-item"><a href="{{ route('nilai-siswa-siswa.show', ['id' => Crypt::encrypt($jadwalKelas->id)]) }}">Siswa </a></li>
            <li class="breadcrumb-item">Nilai Siswa </li>
        </ol>
    </nav>

    <div class="card card-primary">
        <div class="card-header">
          <div class="card-title">
            <div>
                <h3>Pemasukan Nilai Raport</h3>
            </div>

            @if (
                $raportMataPelajaran && $raportMataPelajaran['nilai_pengetahuan'] 
                && $raportMataPelajaran['nilai_pengetahuan'] && $raportMataPelajaran['nilai_pengetahuan']
                && $raportMataPelajaran['nilai_pengetahuan'] && $raportMataPelajaran['nilai_pengetahuan']
                && $raportMataPelajaran['nilai_pengetahuan'] && $raportMataPelajaran['nilai_pengetahuan'] 
                && !$raportMataPelajaran['submit']
            )
            <div class="text-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#submitRaport" data-whatever="@mdo">Submit</button>
            </div>
            @elseif($raportMataPelajaran && $raportMataPelajaran['submit'])
            <div>
                <p class="text-danger">
                    *** RAPORT TELAH DI-SUBMIT ***
                </p>
            </div>
            @endif

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
                                    <td>Nama Kelas</td>
                                    <td>:</td>
                                    <td>{{$pembagianKelas->kelas->kelas. " " . $pembagianKelas->kelas->jurusan->jurusan. " " . $pembagianKelas->nama_kelas}}</td>
                                </tr>
                                <tr>
                                    <td>Wali Kelas</td>
                                    <td>:</td>
                                    <td>{{$pembagianKelas->guru->nama}}</td>
                                </tr>
                                <tr>
                                    <td>Mata Pelajaran</td>
                                    <td>:</td>
                                    <td>{{$mataPelajaran->nama_mapel}}</td>
                                </tr>
                                <tr>
                                    <td>Guru Mata Pelajaran</td>
                                    <td>:</td>
                                    <td>{{$jadwalKelas->guru->nama}}</td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>{{ucfirst($tahunAjar->semester)}}</td>
                                </tr>
                                <tr>
                                    <td>Tahun Pelajaran</td>
                                    <td>:</td>
                                    <td>{{ "$tahunAjar->tahun_ajar_awal". "/" . "$tahunAjar->tahun_ajar_akhir" }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th class="ctr">Tugas-tugas (40%)</th>
                                <th class="ctr">Ulangan Harian (20%)</th>
                                <th class="ctr">UTS (10%)</th>
                                <th class="ctr">UAS (30%)</th>
                                <th class="ctr">Keterampilan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action={{ route('nilai-siswa-siswa.store', ['id_jadwal_kelas' => Crypt::encrypt($jadwalKelas->id), 'id_siswa' => Crypt::encrypt(  $siswa->id)]) }} method="post">
                                @csrf
                                    <tr>
                                        @if ($raport)
                                            <input type="hidden" name="id_raport" value="{{ $raport->id }}">
                                        @endif
                                        
                                        @if ($raportMataPelajaran)
                                            <input type="hidden" name="id_raport_mata_pelajaran" value="{{ $raportMataPelajaran->id }}">
                                        @else
                                            <input type="hidden" name="id_raport_mata_pelajaran" value="">
                                        @endif
                                        
                                        <td>
                                            {{$siswa->name}}
                                            @if ($nilaiSiswa && $nilaiSiswa['id'])
                                                <input type="hidden" name="id" value="{{ $nilaiSiswa['id'] }}">
                                            @else
                                                <input type="hidden" name="id" value="">
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($nilaiSiswa && $nilaiSiswa['tugas'])
                                                <input type="text" name="tugas" maxlength="3" value={{ $nilaiSiswa['tugas'] }} onkeypress="" style="margin: auto;" class="form-control text-center ulha_2_" autocomplete="off">
                                            @else
                                                <input type="text" name="tugas" maxlength="3" onkeypress="" style="margin: auto;" class="form-control text-center" autocomplete="off">
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($nilaiSiswa && $nilaiSiswa['ulangan_harian'])
                                                <input type="text" name="ulangan_harian" maxlength="3" value={{$nilaiSiswa['ulangan_harian']}} onkeypress="" style="margin: auto;" class="form-control text-center ulha_2_" autocomplete="off">
                                            @else
                                                <input type="text" name="ulangan_harian" maxlength="3" onkeypress="" style="margin: auto;" class="form-control text-center" autocomplete="off">
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($nilaiSiswa && $nilaiSiswa['uts'])
                                                <input type="text" name="uts" maxlength="3" value={{$nilaiSiswa['uts']}} onkeypress="" style="margin: auto;" class="form-control text-center uts_" autocomplete="off">
                                            @else
                                                <input type="text" name="uts" maxlength="3" onkeypress="" style="margin: auto;" class="form-control text-center" autocomplete="off">
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($nilaiSiswa && $nilaiSiswa['uas'])
                                                <input type="text" name="uas" maxlength="3" value={{$nilaiSiswa['uas']}} onkeypress="" style="margin: auto;" class="form-control text-center ulha_3_" autocomplete="off">
                                            @else
                                                <input type="text" name="uas" maxlength="3" onkeypress="" style="margin: auto;" class="form-control text-center" autocomplete="off">
                                            @endif
                                        </td>
                                        <td class="ctr sub_">
                                            <button type="submit" id="submit-" class="btn btn-default btn_click" data-id=""><i class="nav-icon fas fa-save"></i></button>
                                        </td>
                                    </tr>
                            </form>
                        </tbody>
                    </table>

                    @if ($raportMataPelajaran)
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th rowspan="2">Nama Siswa</th>
                                    <th class="ctr" colspan="3">Pengetahuan</th>
                                    <th class="ctr" colspan="3">Keterampilan</th>
                                    @if ($raportMataPelajaran && !$raportMataPelajaran['submit'])<th class="ctr" rowspan="2">Aksi</th>@endif
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
                                <form action="{{route('raport-matapelajaran.update')}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <tr>
                                        <td>{{$siswa->name}}</td>
                                        <input type="hidden" name="id_raport_mata_pelajaran" value="{{ $raportMataPelajaran->id }}">
                                        <td class="ctr">
                                            @if ($raportMataPelajaran && $raportMataPelajaran['nilai_pengetahuan'])
                                                <div class="text-center">{{$raportMataPelajaran['nilai_pengetahuan']}}</div>
                                            @else
                                                <div class="text-center"></div>
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($raportMataPelajaran && $raportMataPelajaran['predikat_pengetahuan'])
                                                <div class="text-center">{{$raportMataPelajaran['predikat_pengetahuan']}}</div>
                                            @else
                                                <div class="text-center"></div>
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($raportMataPelajaran && $raportMataPelajaran['deskripsi_pengetahuan'])
                                                <textarea class="form-control " cols="50" rows="5" disabled>{{ $raportMataPelajaran->deskripsi_pengetahuan }}</textarea>
                                            @else
                                                <textarea class="form-control " cols="50" rows="5" disabled></textarea>
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($raportMataPelajaran && $raportMataPelajaran['nilai_keterampilan'])
                                            <input type="text" name="nilai" value="{{ $raportMataPelajaran['nilai_keterampilan'] }}" maxlength="3" class="form-control text-center" autocomplete="off">
                                            @else
                                            <input type="text" name="nilai" maxlength="3" class="form-control text-center" autocomplete="off">
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            @if ($raportMataPelajaran && $raportMataPelajaran['predikat_keterampilan'])
                                            <select name="predikat" class="form-control text-center" id="">
                                                <option value="">-- Pilih Predikat --</option>
                                                <option value="A" @if($raportMataPelajaran['predikat_keterampilan'] == 'A') selected @endif>A</option>
                                                <option value="B" @if($raportMataPelajaran['predikat_keterampilan'] == 'B') selected @endif>B</option>
                                                <option value="C" @if($raportMataPelajaran['predikat_keterampilan'] == 'C') selected @endif>C</option>
                                                <option value="D" @if($raportMataPelajaran['predikat_keterampilan'] == 'D') selected @endif>D</option>
                                            </select>
                                            @else
                                            <select name="predikat" class="form-control text-center" id="">
                                                <option value="" selected>-- Pilih Predikat --</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                            @endif  
                                        </td>
                                        <td class="ctr">
                                            @if ($raportMataPelajaran && $raportMataPelajaran['deskripsi_keterampilan'])
                                            <textarea class="form-control" name="deskripsi" cols="50" rows="5">{{$raportMataPelajaran['deskripsi_keterampilan']}}</textarea>
                                            @else
                                            <textarea class="form-control" name="deskripsi" cols="50" rows="5"></textarea>
                                            @endif
                                        </td>
                                        <td class="ctr">
                                            <button type="submit" class="btn btn-default btn_click"><i class="nav-icon fas fa-save"></i></button>
                                        </td>            
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

@if (
    $raportMataPelajaran && $raportMataPelajaran['nilai_pengetahuan'] 
    && $raportMataPelajaran['nilai_pengetahuan'] && $raportMataPelajaran['nilai_pengetahuan']
    && $raportMataPelajaran['nilai_pengetahuan'] && $raportMataPelajaran['nilai_pengetahuan']
    && $raportMataPelajaran['nilai_pengetahuan'] && $raportMataPelajaran['nilai_pengetahuan'] 
    && !$raportMataPelajaran['submit']
)
<div class="modal fade bd-example-modal-lg" id="submitRaport" tabindex="-1" role="dialog" aria-labelledby="submitRaport" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="submitRaport">Submit Raport</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('raport-matapelajaran-submit.update', ['id' => Crypt::encrypt($raportMataPelajaran['id']) ]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <p class="text-center text-danger">
                    Nilai akan di submit dan tidak akan bisa di rubah lagi, anda yakin?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </form>

    </div>
    </div>
</div>
@endif
@endsection
