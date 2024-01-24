@extends('layouts.app')

@include('layouts.guru-layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('perwalian-kelas.index') }}">Kelas</a> </li>
            <li class="breadcrumb-item active">Siswa</li>
        </ol>
    </nav>

    @if (!$rekap)
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submitRaport" data-whatever="@mdo">
            Submit Raport Kelas Ini
        </button>
    @else
        <div>
            <p class="text-danger">
                *** RAPORT KELAS TELAH TEREKAP ***
            </p>
        </div>
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
</div>

@if (!$rekap)
<div class="modal fade bd-example-modal-lg" id="submitRaport" tabindex="-1" role="dialog" aria-labelledby="submitRaport" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="submitRaport">Submit Raport</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('perwalian-kelas-raport-submit.update', ['id' => Crypt::encrypt($id)]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <p class="text-center text-danger">
                    Raport akan di rekap dan tidak akan bisa di rubah lagi, anda yakin?
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