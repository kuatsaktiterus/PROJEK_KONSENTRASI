@section('thumbnailProfil')
    <img 
    src="{{asset('storage/image/siswa/'.Auth::user()->siswa->foto)}}"
    alt="Foto"
    class="rounded-circle" width="40px" height="40px">
@endsection

@section('profil')
<a class="dropdown-item" href="{{ route('profil-siswa.index') }}"><i class="fa fa-user pr-2"></i> Profile</a>
<div class="dropdown-divider"></div>
@endsection

@section('sidebar')
    @include('app.partial.siswa.sidebar')
@endsection