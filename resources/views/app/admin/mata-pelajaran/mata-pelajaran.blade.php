@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
<!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Mata Pelajaran</li>
        </ol>
    </nav>
    <div class="mt-1 mb-3 button-container">
        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahModal" data-whatever="@mdo">Tambah
            Data Mata Pelajaran</button>
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

<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Tambah Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('mata-pelajaran.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="mapel" class="col-form-label">Nama Mata Pelajaran</label>
                <input type="text" class="form-control" id="mapel" name="nama_mapel" required value="{{ old('nama_mapel') }}">
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
    function actionmapel(action,id){
        $.ajax({
        url:"mata-pelajaran/"+action+"/"+id,
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