@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Siswa</li>
        </ol>
    </nav>
    <div class="mt-1 mb-3 button-container">
        <a class="btn btn-primary" href="{{ route("siswa.create") }}" style="color:white !important;">Tambah
            Data Siswa</a>
        <button class="btn btn-primary" data-toggle="modal" data-target="#importDataSiswa" data-whatever="@mdo">Import
            Data Excel Siswa </button>
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

<div class="modal fade bd-example-modal-lg" id="importDataSiswa" tabindex="-1" role="dialog" aria-labelledby="importDataSiswa" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="importDataSiswa">Tambah Data Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="{{route('siswa.store.excel')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Contoh Format File &raquo;</label>
                <a href="{{asset('contoh file excel/Contoh Format File Excel Siswa.xlsx')}}" target="_blank">File Excel</a>
            </div>
            <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Import Data Siswa</label>
                    <input type="file" class="form-control" id="recipient-name" name="file" required accept=".xlsx">
                    <small>
                        Masukkan file Excel <br>
                        Hanya menerima file berformat XLSX
                    </small>
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
    function actionsiswa(id){
    $.ajax({
    url:"siswa/"+id+"/delete",
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