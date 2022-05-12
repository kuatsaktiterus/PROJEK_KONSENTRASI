@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-ite">Jurusan</li>
        </ol>
    </nav>

    <div class="mt-1 mb-3 button-container">
        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahDataJurusan" data-whatever="@mdo">Tambah
            Data Jurusan </button>
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
<div class="modal fade" id="tambahDataJurusan" tabindex="-1" role="dialog" aria-labelledby="tambahDataJurusan" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="tambahDataJurusan">Tambah Jurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('jurusan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="jurusan" class="col-form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" placeholder="Masukkan Nama Jurusan" required name="jurusan" value="{{ old('jurusan') }}">
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
    function actionjurusan(action, id){
    $.ajax({
    url:"jurusan/"+action+"/"+id,
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