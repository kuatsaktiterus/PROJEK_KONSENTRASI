@extends('layouts.app')

@include('layouts.admin_layout')

@section('content_right')
    <!--Content right-->    
<div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Guru</li>
        </ol>
    </nav>
    <div class="mt-1 mb-3 button-container">
        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahData" data-whatever="@mdo">Tambah
            Data Guru</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#importDataGuru" data-whatever="@mdo">Import
            Data Excel Guru </button>
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

<div class="modal fade bd-example-modal-lg" id="importDataGuru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Guru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form action="{{route('guru.store.excel')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Contoh Format File &raquo;</label>
                <a href="{{asset('contoh file excel/Contoh Format File Excel Guru.xlsx')}}" target="_blank">File Excel</a>
            </div>
            <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Import Data Guru</label>
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

<div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="tambahDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="tambahDataLabel">Tambah Data Guru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form class="form-horizontal mt-4 mb-5" action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" required name="nama" placeholder="Heri" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="nip" class="col-form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" required name="nip" placeholder="199011092014021007" value="{{ old('nip') }}">
                        </div>
                        <div class="form-group">
                            <label for="golongan" class="col-form-label">Golongan</label>
                            <input type="text" class="form-control" id="golongan" required name="golongan" placeholder="IV/a" value="{{ old('golongan') }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">- Pilih Jenis Kelamin -</option>
                                <option value="laki-laki" @if (old('jenis_kelamin') == 'laki-laki') selected @endif>Laki-laki</option>
                                <option value="perempuan" @if (old('jenis_kelamin') == 'perempuan') selected @endif>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon" class="col-form-label">No Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" required name="no_telepon" placeholder="081355638729" value="{{ old('no_telepon') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alamat" class="col-form-label">Alamat</label>
                            <textarea name="alamat" class="form-control rounded-0" rows="10" placeholder="Jl. Tidung VI Stp3 No.53">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="pendidikan_terakhir" class="col-form-label">Pendidikan Terakhir</label>
                            <input type="text" class="form-control" id="pendidikan_terakhir" required name="pendidikan_terakhir" placeholder="S1-Teknik Informatika" value="{{ old('pendidikan_terakhir') }}">
                        </div>
                        <div class="form-group">
                            <label for="jurusan_pendidikan" class="col-form-label">Jurusan Pendidikan</label>
                            <input type="text" class="form-control" id="jurusan_pendidikan" required name="jurusan_pendidikan" placeholder="Pendidikan Bimbingan Konseling" value="{{ old('jurusan_pendidikan') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group center">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="exampleFormControlFile1">File input</label>
                            <input type="file" class="form-control" id="exampleFormControlFile1" accept="image/jpeg, image/jpg, image/png, image/webp" name="foto" />
                            <small class="text-danger">Format foto yang diterima adalah jpeg, jpg, png, webp dengan ukuran
                                maksimal 2 MB.</small>
                            <br><br><br>
                            <div class="text-center">
                                <img class="img-fluid rounded text-center" src="{{ asset('images/image.png') }}"
                                    id="photo_preview" style="max-height: 250px;">
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
@endsection
@section('script')
{{-- action hapus data guru --}}
<script>
    function actionguru(id){
    $.ajax({
    url:"guru/"+id+"/delete",
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

{{-- menampilkan preview foto --}}
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