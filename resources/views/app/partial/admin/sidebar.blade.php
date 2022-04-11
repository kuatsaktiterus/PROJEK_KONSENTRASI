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
                {{-- <li class="child"><a href="{{ route('siswa.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Siswa</a></li>
                <li class="child"><a href="{{ route('guru.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Guru</a></li> --}}
            </ul>
        </li>

        <li class="parent">
            <a href="#" class=""><i class="fas fa-chalkboard mr-3"></i>
                <span class="none">Jadwal Dan Kelas</i></span>
            </a>
        </li>

        <li class="parent">
            <a href="#" class=""><i class="fas fa-book mr-3"> </i>
                <span class="none">Mata Pelajaran</span>
            </a>
        </li>

        <li class="parent">
            <a href="#" class=""><i class="far fa-flag mr-3"></i>
                <span class="none">Pengumuman</i></span>
            </a>
        </li>
    </ul>
</div>