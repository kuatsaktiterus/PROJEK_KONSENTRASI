@extends('layouts.app')

@include('layouts.siswa-layout')

@section('content_right')
<!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Ubah Password</li>
            
        </ol>
    </nav>

    <div class="row mt-3">
        <div class="col-sm-12">
            <!--Default elements-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <h6 class="mb-2">Ubah Password</h6>
                
                <form class="form-horizontal mt-4 mb-5" action="{{ route('ganti-password-siswa.put') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- user ganti password --}}
                    <center>
                        <div class="card bg-light w-50">
                            <div class="card-header">
                                <h5>USER</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username" class="col-form-label">Username</label>
                                    <input type="text" class="form-control w-50" id="username" value="{{$siswa->user->username }}" readonly>
                                </div>
                                    <div class="form-group">
                                    <label for="password" class="col-form-label">Password lama</label>
                                    <input type="password" class="form-control w-50" id="password" name="password" placeholder="Isikan password lama anda">
                                </div>
                                <div class="form-group">
                                    <label for="passwordBaru" class="col-form-label">Password baru</label>
                                    <input type="password" class="form-control w-50" id="passwordBaru" name="newPassword" placeholder="Isikan password baru, minimal 8 karakter">
                                </div>
                                <div class="form-group">
                                    <label for="konfirmasiPassword" class="col-form-label">Konfirmasi Password baru</label>
                                    <input type="password" class="form-control w-50" id="konfirmasiPassword" name="konfirmasiPassword" placeholder="Isikan password baru, minimal 8 karakter">
                                </div>
                                <small>
                                    <p>* Untuk keamanan password harus setidaknya terdiri dari 8 karakter, huruf besar dan kecil, angka, serta simbol</p>
                                </small>
                            </div>
                          </div>
                        </div>
                      </center>
                <button type="submit" class="btn btn-primary">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection