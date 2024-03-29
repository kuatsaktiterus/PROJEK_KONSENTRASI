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
            <a href="#" onclick="toggle_menu('user'); return false"><i class="fas fa-chalkboard-teacher mr-3"> </i>
                <span class="none">User <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="user">
                @if (Auth::user()->role == 'super_admin')
                    <li class="child"><a href="{{ route('admin.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Admin</a></li>
                @endif
                <li class="child"><a href="{{ route('siswa.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Siswa</a></li>
                <li class="child"><a href="{{ route('guru.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Guru</a></li>
            </ul>
        </li>

        <li class="parent">
            <a href="#" onclick="toggle_menu('jadwal'); return false" class=""><i class="fas fa-chalkboard mr-3"></i>
                <span class="none">Jadwal Dan Kelas <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="jadwal">
                <li class="child"><a href="{{ route('jadwal.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Jam Mata Pelajaran</a></li>
                <li class="child"><a href="{{ route('jurusan.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Jurusan Dan Kelas</a></li>
            </ul>
        </li>

        <li class="parent">
            <a href="{{ route('mata-pelajaran.index') }}" class=""><i class="fas fa-book mr-3"> </i>
                <span class="none">Mata Pelajaran</span>
            </a>
        </li>
        
        <li class="parent">
            <a href="#" onclick="toggle_menu('pengumuman'); return false" class=""><i class="far fa-flag mr-3"></i>
                <span class="none">Pengumuman <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="pengumuman">
                <li class="child"><a href="{{ route('pengumuman-sekolah.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Pengumuman Sekolah</a></li>
                <li class="child"><a href="{{ route('pengumuman-guru.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Pengumuman Guru</a></li>
            </ul>
        </li>

        <li class="parent">
            <a href="{{ route('nilai-semester.index') }}" class=""><i class="fa fa-archive mr-3"></i>
                <span class="none">Nilai dan semester</span>
            </a>
        </li>
    </ul>
</div>