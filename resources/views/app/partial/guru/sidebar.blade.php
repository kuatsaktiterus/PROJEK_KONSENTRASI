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
        
        @if (Auth::user()->guru->isWaliKelas(Auth::user()->guru->id))
        <li class="parent">
            <a href="#" onclick="toggle_menu('nilai'); return false" class=""><i class="fa fa-file-text mr-3"></i>
                <span class="none">Jadwal Dan Kelas <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="nilai">
                <li class="child"><a href="{{ route('nilai-siswa.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> nilai</a></li>
                <li class="child"><a href="{{ route('perwalian-kelas.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Perwalian Kelas</a></li>
            </ul>
        </li>
        @else
        <li class="parent">
            <a href="{{ route('nilai-siswa.index') }}"class=""><i class="fa fa-file-text mr-3"></i>
                <span class="none"> Nilai </span>
            </a>
        </li>
        @endif
        
    </ul>
</div>