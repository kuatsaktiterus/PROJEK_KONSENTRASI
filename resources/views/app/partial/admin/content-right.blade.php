<div class="mt-1 mb-3 button-container">
    <div class="row pl-0">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahAdmin}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Admin</small></p>
                    </div>
                </div>
            </div>
        </div>

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
                        <p><small class="text-muted bc-description">Jumlah Kelas Di Sekolah</small></p>
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
</div>