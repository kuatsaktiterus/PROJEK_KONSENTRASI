@extends('layouts.app')

@include('layouts.siswa-layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Info Kelas {{$data->name}}</li>
        </ol>
    </nav>

    <div class="mt-1 mb-3 button-container">
        <center>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
                <div class="bg-white border shadow">
                    <div class="media p-4">
                        <div class="align-self-center mr-3 rounded-circle">
                            <img src="{{asset('storage/image/guru/'.$guru->foto)}}" class="img-thumbnail rounded">
                        </div>
                        <div class="media-body pl-2">
                            <h3 class="mt-0 mb-0"><strong>{{$guru->nama}}</strong></h3>
                            <p><small class="text-muted bc-description">Wali Kelas</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </center>
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
</div>
@endsection