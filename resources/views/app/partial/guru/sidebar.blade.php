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
            <a href="{{ route('jadwal-kelas-guru.index') }}"class=""><i class="fas fa-calendar-alt mr-3"></i>
                <span class="none"> Jadwal Kelas</span>
            </a>
        </li>

        <li class="parent">
            <a href="{{ route('mata-pelajaran-guru.index') }}"class=""><i class="fas fa-book mr-3"></i>
                <span class="none"> Mata Pelajaran</span>
            </a>
        </li>

        <li class="parent">
            <a href="{{ route('siswa-guru.index') }}"class=""><i class="fas fa-user-tie mr-3"></i>
                <span class="none"> Siswa </span>
            </a>
        </li>

        <li class="parent">
            <a href="{{ route('pengumuman-guru.index') }}"class=""><i class="far fa-flag mr-3"></i>
                <span class="none"> Pengumuman </span>
            </a>
        </li>
    </ul>
</div>