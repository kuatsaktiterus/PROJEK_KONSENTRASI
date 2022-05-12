@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Jam Mata Pelajaran</li>
        </ol>
    </nav>
    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahDataJadwal" data-whatever="@mdo">Tambah
        Data Jam Mata Pelajaran</button>

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

<div class="modal fade" id="tambahDataJadwal" tabindex="-1" role="dialog" aria-labelledby="tambahDataJadwal" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="tambahDataJadwal">Tambah Jadwal Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('jadwal.store') }}">
            @csrf
            <div class="form-group">
                <center>
                    <label for="jam_mulai" class="col-form-label">Jam Mulai</label>
                    <input type="time" class="form-control w-75" id="jam_mulai"  required name="jam_mulai" value="{{ old('jam_mulai') }}">
                </center>
            </div>
            <div class="form-group">
                <center>
                    <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                    <input type="time" class="form-control w-75" id="jam_selesai"  required name="jam_selesai" value="{{ old('jam_selesai') }}">
                </center>
            </div>
            <div class="form-group">
                <center>
                    <label for="hari" class="col-form-label">Hari</label>
                    <select name="hari" id="hari" class="form-control w-75" required>
                        <option value="">--    Pilih Salah Satu    --</option>
                        <option value="1" @if( old('hari') == 1) selected @endif>Senin</option>
                        <option value="2" @if( old('hari') == 2) selected @endif>Selasa</option>
                        <option value="3" @if( old('hari') == 3) selected @endif>Rabu</option>
                        <option value="4" @if( old('hari') == 4) selected @endif>Kamis</option>
                        <option value="5" @if( old('hari') == 5) selected @endif>Jumat</option>
                        <option value="6" @if( old('hari') == 6) selected @endif>Sabtu</option>
                        <option value="0" @if( old('hari') == 7) selected @endif>Minggu</option>
                    </select>
                </center>
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
    function actionjadwal(action, id){
    $.ajax({
    url:"jadwal/"+action+"/"+id,
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