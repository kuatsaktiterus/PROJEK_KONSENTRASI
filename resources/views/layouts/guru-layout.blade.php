@section('thumbnailProfil')
    <img 
    src="{{asset('storage/image/guru/'.Auth::user()->guru->foto)}}"
    alt="Foto"
    class="rounded-circle" width="40px" height="40px">
@endsection

@section('profil')
<a class="dropdown-item" href="{{ route('profil-guru.index') }}"><i class="fa fa-user pr-2"></i> Profile</a>
<div class="dropdown-divider"></div>
@endsection

{{-- sidebar menu guru --}}
@section('sidebar')
    @include('app.partial.guru.sidebar')
@endsection