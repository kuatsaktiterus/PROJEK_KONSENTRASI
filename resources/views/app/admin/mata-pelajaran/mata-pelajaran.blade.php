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
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Tambah Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('mata-pelajaran.store') }}" class="form-horizontal mt-4 mb-5" method="POST">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mapel" class="col-form-label">Nama Mata Pelajaran</label>
                        <input type="text" class="form-control" id="mapel" name="nama_mapel" required value="{{ old('nama_mapel') }}">
                    </div>
                    <div class="form-group">
                        <label for="semester" class="col-form-label">Semester</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kkm" class="col-form-label">KKM</label>
                        <input type="text" class="form-control" id="kkm" name="kkm" required value="{{ old('kkm') }}">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="des_a" class="col-form-label">Deskripsi Nilai A</label>
                        <textarea name="deskripsi_predikat_a" id="des_a" cols="43" rows="5">{{ old('deskripsi_predikat_a') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="des_c" class="col-form-label">Deskripsi Nilai C</label>
                        <textarea name="deskripsi_predikat_c" id="des_c" cols="43" rows="5">{{ old('deskripsi_predikat_c') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="des_b" class="col-form-label">Deskripsi Nilai B</label>
                        <textarea name="deskripsi_predikat_b" id="des_b" cols="43" rows="5">{{ old('deskripsi_predikat_b') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="des_d" class="col-form-label">Deskripsi Nilai D</label>
                        <textarea name="deskripsi_predikat_d" id="des_d" cols="43" rows="5">{{ old('deskripsi_predikat_d') }}</textarea>
                    </div>
                </div>
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