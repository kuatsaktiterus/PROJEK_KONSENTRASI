@section('sidebar')
<div class="sidebar-menu-container">
    <ul class="sidebar-menu mt-4 mb-4">
        {{-- dashboard section --}}
        <li class="parent">
            <a href="{{ route('dashboard') }}"class=""><i class="fa fa-dashboard mr-3"></i>
                <span class="none"> Dashboard </span>
            </a>
        </li>

        {{-- user section --}}
        <li class="parent">
            <a href="#" onclick="toggle_menu('jadwal'); return false" class=""><i class="fas fa-landmark mr-3"></i>
                <span class="none">Kelas <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="jadwal">
                <li class="child"><a href="" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Jadwal Kelas</a></li>
                <li class="child"><a href="" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Info Kelas</a></li>
            </ul>
        </li>

        <li class="parent">
            <a href=""class=""></i><i class="fas fa-book mr-3"></i>
                <span class="none"> Mata Pelajaran</span>
            </a>
        </li>

        <li class="parent">
            <a href=""class=""></i><i class="fas fa-user-tie mr-3"></i>
                <span class="none"> Guru </span>
            </a>
        </li>
    </ul>
</div>
@endsection

{{-- dashboard siswa --}}
@section('content_right')

<div class="mt-1 mb-3 button-container">
    <div class="row pl-0">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahSiswa}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Siswa</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahGuru}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Guru</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahKelas}}</strong></h3>
                        <p>
                            <small class="text-muted bc-description">
                                Jumlah Kelas Di Jurusan {{$user->jurusan->jurusan}}
                                @if ($user->pembagiankelassiswa->count() == 0)
                                    0
                                @else
                                    {{$user->pembagiankelassiswa[0]->pembagiankelas->kelas->kelas}}
                                @endif  <!-- data kelas --> 
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-6">
        <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
            <h6 class="mb-3">Pengumuman</h6><hr>
            
            <div class="updates-wrapper border-left">
                @foreach ($pengumumanSekolah as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Sekolah</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}}</span>
                </div>
                @endforeach
                @foreach ($pengumumanGuru as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Guru</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}} dari {{ $data->guru->nama }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
            <h6 class="mb-3">Jadwal Hari Ini</h6><hr>
            @foreach ($jadwalHarian as $data)
                <div class="updates-wrapper border-left">
                    <div class="updates-content p-3 up-primary">
                        <h6 class="bc-header-small">{{ $data->matapelajaran->nama_mapel }}</h6>
                        <span class="small"><i class="fas fa-clock text-success"></i> {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai)->translatedFormat('H:i') }} - {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai)->translatedFormat('H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection