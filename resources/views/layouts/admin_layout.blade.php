@section('thumbnailProfil')
    @if (Auth::user()->role == 'super_admin')
        <span>Super Admin</span>
    @elseif (Auth::user()->role == 'admin')
        <span>{{Auth::user()->admins->nama }}</span>
    @endif
@endsection

@section('profil')
    @if (Auth::user()->role == 'super_admin')
        <button class="dropdown-item" data-toggle="modal" data-target="#edit_modal" data-whatever="@mdo"><i class="fas fa-lock pr-2"></i>
            Ubah Password</button>
    @endif
@endsection

@section('modal')
    @if (Auth::user()->role == 'super_admin')
        @include('app.partial.admin.modal')
    @endif
@endsection

@section('sidebar')
    @include('app.partial.admin.sidebar')
@endsection