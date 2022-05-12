@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">Siswa</a></li>
            <li class="breadcrumb-item active">Edit Data Siswa</li>
            
        </ol>
    </nav>

    <div class="row mt-3">
        <div class="col-sm-12">
            <!--Default elements-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <h6 class="mb-2">Edit Data Siswa</h6>
                
                <form class="form-horizontal mt-4 mb-5" action="{{ route('siswa.update', ['siswa' => Crypt::encrypt($siswa->id)]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="text-center">
                        <img class="img-fluid rounded text-center" src="{{ asset('storage/image/siswa/'.$siswa->foto) }}"
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
                            <input type="text" class="form-control" id="input-1" placeholder="Ricky Heri" name="nama" required value="{{ $siswa->name }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-2">NISN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-2" placeholder="161348" disabled required value="{{ $siswa->nisn }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-3">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-3" placeholder="737********" disabled required value="{{ $siswa->nik }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="jk">Jenis Kelamin:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="jk" name="jenis_kelamin" required>
                                <option value="">- Pilih jenis kelamin -</option>
                                <option value="laki-laki" @if($siswa->jenis_kelamin == 'laki-laki') selected @endif>Laki-laki</option>
                                <option value="perempuan" @if( $siswa->jenis_kelamin == 'perempuan') selected @endif>Perempuan</option>
                              </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-4">No.Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" id="input-4" class="form-control" placeholder="081355638729" name="no_telepon" required value="{{ $siswa->no_telepon }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-5">Tempat Lahir</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-5" placeholder="Makassar" name="tempat_lahir" required value="{{ $siswa->tempat_lahir }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-6">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type="Date" class="form-control" id="input-6" placeholder="12/12/2012" name="tanggal_lahir" required value="{{ $siswa->tanggal_lahir }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-7">Agama:</label>
                        <div class="col-sm-10">
                            <select id="agama" name="agama" class="form-control" required>
                                <option value="">- Pilih salah satu opsi -</option>
                                <option value="islam" @if( $siswa->agama == 'islam') selected @endif>Islam</option>
                                <option value="kristen protestan" @if( $siswa->agama == 'kristen protestan') selected @endif>Kristen Protestan</option>
                                <option value="kristen katolik" @if( $siswa->agama == 'kristen katolik') selected @endif>Kristen Katolik</option>
                                <option value="hindu" @if( $siswa->agama == 'hindu') selected @endif>Hindu</option>
                                <option value="buddha" @if( $siswa->agama == 'buddha') selected @endif>Buddha</option>
                                <option value="konghucu" @if( $siswa->agama == 'konghucu') selected @endif>Konghucu</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-8">Alamat Lengkap</label>
                        <div class="col-sm-10">
                            <textarea rows="5" class="form-control" id="input-8" placeholder="Jl Matahari 3 No.53 Stp.3" name="alamat_lengkap" required>{{ $siswa->alamat_lengkap }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputalamatrt" class="control-label col-sm-2">Alamat RT</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputalamatrt" placeholder="02" name="alamat_rt" required value="{{ $siswa->alamat_rt }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="alamatrw">Alamat RW</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamatrw" placeholder="14" name="alamat_rw" required value="{{ $siswa->alamat_rw }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-9">Alamat Kelurahan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-9" placeholder="Rappocini" name="alamat_kelurahan" required value="{{ $siswa->alamat_kelurahan }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-10">Alamat Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-10" placeholder="Mappala" name="alamat_kecamatan" required value="{{ $siswa->alamat_kecamatan }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="input-11">Kode Pos</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="input-11" placeholder="90222" name="kode_pos" required value="{{ $siswa->kode_pos }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="tinggal_bersama">Tinggal Bersama</label>
                        <div class="col-sm-10">
                            <select name="tinggal_bersama" id="tinggal_bersama" class="form-control" required>
                                <option value="">- Pilih salah satu opsi -</option>
                                <option value="orang tua" @if( $siswa->tinggal_bersama == 'orang tua') selected @endif>Orang Tua</option>
                                <option value="wali" @if( $siswa->tinggal_bersama == 'wali') selected @endif>Wali Siswa </option>
                                <option value="sendiri" @if( $siswa->tinggal_bersama == 'sendiri') selected @endif>Sendiri</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="transportasi">Transportasi</label>
                        <div class="col-sm-10">
                            <select name="transportasi" id="transportasi" class="form-control" required>
                                <option value="">- Pilih salah satu opsi -</option>
                                <option value="angkutan umum" @if( $siswa->transportasi == 'angkutan umum') selected @endif>Angkutan Umum</option>
                                <option value="kendaraan pribadi" @if( $siswa->transportasi == 'kendaraan pribadi') selected @endif>Kendaraan pribadi</option>
                                <option value="antar jemput" @if( $siswa->transportasi == 'antar jemput') selected @endif>Antar Jemput</option>
                                <option value="jalan kaki" @if( $siswa->transportasi == 'jalan kaki') selected @endif>Jalan Kaki</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-2" for="jurusan">Jurusan</label>
                        <div class="col-sm-10">
                            <select name="jurusan" id="jurusan" class="form-control" required>
                                <option value="">- Pilih salah satu opsi -</option>
                                @foreach ($jurusan as $item)
                                  <option value="{{$item->id}}" @if( $siswa->id_jurusan == $item->id) selected @endif>{{$item->jurusan}}</option> 
                                @endforeach
                              </select>
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
                                <input type="text" class="form-control w-50" id="username" value="{{$siswa->user->username }}" readonly>
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