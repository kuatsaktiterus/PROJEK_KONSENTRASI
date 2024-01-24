@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('jurusan.index') }}"> Jurusan</a> </li>
            <li class="breadcrumb-item"><a href="{{ route('kelas.show', ['kela' => Crypt::encrypt($jurusan->id)] )}}"> Pembagian Kelas Jurusan {{$jurusan->jurusan}}</a></li>
            <li class="breadcrumb-item active">Kelas {{$kelas}} Jurusan {{$jurusan->jurusan}}</li>
        </ol>
    </nav>

    @if ($tahunAjar)
        <div class="mt-1 mb-3 button-container">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahDataKelas" data-whatever="@mdo">Tambah
                Data Kelas </button>
        </div>
    @else
        <p>
            *** Jalankan Semester Untuk Menambah Kelas ***
        </p>
    @endif

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

@if ($tahunAjar)
    <div class="modal fade" id="tambahDataKelas" tabindex="-1" role="dialog" aria-labelledby="tambahDataKelas" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="tambahDataKelas">Tambah Kelas</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <form action="{{ route('pembagian-kelas.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="kelas" class="col-form-label">Kelas</label>
                    <input type="text" class="form-control" id="kelas" name="nama_kelas" placeholder="Kelas A" value="{{ old('nama_kelas') }}">
                </div>
                <div class="form-group">
                    <label for="wali_kelas" class="col-form-label">Wali Kelas</label>
                    <select name="wali_kelas" id="wali_kelas" class="form-control">
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" @if (old('wali_kelas') == $guru->id) selected @endif>{{ $guru->nip }} - {{ $guru->nama }}</option>
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
@endif

@endsection
@section('script')
<script>
    $('#wali_kelas').chosen({ width: '100%' });
    function actionpembagiankelas(action, id){
    $.ajax({
    url:"/app/pembagian-kelas-siswa/action/"+action+"/"+id,
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