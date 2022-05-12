@extends('layouts.app')

@include('layouts.admin_layout')

<?php
\Carbon\Carbon::setLocale('id_ID');
$weekdays = \Carbon\Carbon::getDays();
?>

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('jurusan.index') }}"> Jurusan</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('kelas.show', ['kela' => Crypt::encrypt($data->kelas->jurusan->id)] )}}"> Pembagian Kelas Jurusan {{$data->kelas->jurusan->jurusan}}</a></li>
            <li class="breadcrumb-item"><a href="/app/pembagian-kelas/{{Crypt::encrypt($data->id_kelas)}}"> Kelas {{$data->kelas->kelas}} Jurusan {{$data->kelas->jurusan->jurusan}}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pembagian-kelas-siswa.show', ['pembagian_kelas_siswa' => Crypt::encrypt($data->id)]) }}"> Pembagian Kelas</a>  {{$data->kelas->kelas}} {{$data->kelas->jurusan->jurusan}}</li> 
            <li class="breadcrumb-item active">Jadwal Kelas {{$data->kelas->kelas}} {{$data->nama_kelas}} Jurusan {{$data->kelas->jurusan->jurusan}}</li> 
        </ol>
    </nav>

    <div class="mt-1 mb-3 button-container">
        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahDataMapel" data-whatever="@mdo">Tambah
            Data Jadwal Kelas</button>
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

<div class="modal fade" id="tambahDataMapel" tabindex="-1" role="dialog" aria-labelledby="tambahDataMapel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="tambahDataMapel">Tambah Jadwal Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('jadwal-kelas.store') }}">
            @csrf
            <input type="hidden" name="pembagian_kelas" value='{{$data->id}}'>
            <div class="form-group">
            <label for="mapel" class="col-form-label">Mata Pelajaran</label>
                <select name="mapel" class="form-control" id="mapel" required>
                    <option value="">-- Pilih salah satu mata pelajaran  --</option>
                    @foreach ($matapelajaran as $data)
                    <option value="{{$data->id}}">{{$data->nama_mapel}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
            <label for="pengajar" class="col-form-label" >Pengajar</label>
                <select name="pengajar" class="form-control" id="pengajar" required>
                    <option value="">-- Pilih salah satu guru untuk menjadi pengajar  --</option>
                    @foreach ($pengajar as $data)
                    <option value="{{$data->id}}">{{$data->nip}} - {{$data->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
            <label for="jam" class="col-form-label" >Jadwal</label>
                <select name="jadwal" class="form-control" id="jam" required>
                    <option value="">-- Pilih salah satu jam mata pelajaran  --</option>
                    @foreach ($jadwal as $data)
                    <option value="{{$data->id}}">Hari = {{ \Carbon\Carbon::create($weekdays[$data->hari])->dayName; }} Jam Mulai = {{$data->jam_mulai}} Jam Selesai = {{$data->jam_selesai}}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#pembagian_kelas').chosen({ width: '100%' });
    $('#mapel').chosen({ width: '100%' });
    $('#pengajar').chosen({ width: '100%' });
    $('#jam').chosen({ width: '100%' });
    function actionjadwalkelas(action, id){
    $.ajax({
    url:""+action+"/"+id,
    method:"GET",
        success:function(data){
            $('#result').html(data.html);
        },
        error:function() {
           alert("gagal");
        }
    });
    }
</script>
@endsection