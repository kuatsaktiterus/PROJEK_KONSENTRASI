@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
            <li class="breadcrumb-item active">Edit Data Guru</li>
            
        </ol>
    </nav>

    <div class="row mt-3">
        <div class="col-sm-12">
            <!--Default elements-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <h6 class="mb-2">Edit Data Guru</h6>
                
                <form class="form-horizontal mt-4 mb-5" action="{{ route('guru.update', ['guru' => Crypt::encrypt($guru->id)]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="text-center">
                        <img class="img-fluid rounded text-center" src="{{ asset('storage/image/guru/'.$guru->foto) }}"
                            id="photo_preview" style="max-height: 250px;">
                    </div>
                    <br>
                    <center>
                        <input type="file" class="form-control w-25" id="exampleFormControlFile1" accept="image/jpeg, image/jpg, image/png, image/webp" name="foto" />
                        <small class="text-danger">Format foto yang diterima adalah jpeg, jpg, png, webp dengan ukuran
                            maksimal 2 MB.</small>
                    </center>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-1">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-1" placeholder="Heri" name="nama" required value="{{ $guru->nama }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-2">Nip</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-2" placeholder="199011092014021007" disabled value="{{ $guru->nip }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-3">Golongan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-3" placeholder="IV/a" name="golongan" required value="{{ $guru->golongan }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="jk">Jenis Kelamin:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="jk" name="jenis_kelamin" required>
                                <option value="">- Pilih jenis kelamin -</option>
                                <option value="laki-laki" @if($guru->jenis_kelamin == 'laki-laki') selected @endif>Laki-laki</option>
                                <option value="perempuan" @if( $guru->jenis_kelamin == 'perempuan') selected @endif>Perempuan</option>
                              </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-4">No Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-4" placeholder="081322538729" name="no_telepon" required value="{{ $guru->no_telepon }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-5">Alamat</label>
                        <div class="col-sm-10">
                            <textarea rows="5" class="form-control" id="input-5" placeholder="Jl Matahari 3 No.53 Stp.3" name="alamat" required>{{ $guru->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-6">Pendidikan Terakhir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-6" placeholder="SD" name="pendidikan_terakhir" required value="{{ $guru->pendidikan_terakhir }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-7">Jurusan Pendididikan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-7" placeholder="Pendidikan Bimbingan Konseling" name="jurusan_pendidikan" required value="{{ $guru->jurusan_pendidikan }}"/>
                        </div>
                    </div>

                    {{-- user ganti password --}}
                    <center>
                        <div class="card bg-light w-50">
                            <div class="card-header">
                                <h5>USER</h5>
                            </div>
                            <div class="card-body">
                            <div class="form-group">
                                <label for="username" class="col-form-label">Username</label>
                                <input type="text" class="form-control w-50" id="username" value="{{$guru->user->username }}" readonly>
                            </div>
                                <div class="form-group">
                                <label for="password" class="col-form-label">Password</label>
                                <input type="password" class="form-control w-50" id="password" name="password" placeholder="Isikan password baru, minimal 8 karakter">
                            </div>
                            <small>
                                <p>* Untuk keamanan password harus setidaknya terdiri dari 8 karakter, huruf besar dan kecil, angka, serta simbol</p>
                            </small>
                          </div>
                        </div>
                    </center>
                <button type="submit" class="btn btn-primary">Edit Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#photo_preview').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#exampleFormControlFile1").change(function () {
    readURL(this);
  });
</script>
@endsection