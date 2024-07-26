@php
    use App\Helpers\FiturHelper;
@endphp

@if (FiturHelper::showKaprodi())
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{route('kaprodi.dashboard') }} class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/logo1.png') }}" width="180" alt=""
                style="margin-top: 20px; " />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-home nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('kaprodi.dashboard') }}"
                        aria-expanded="false">
                        <span>
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}"
                        aria-expanded="false">
                        <span>
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('Pembimbing.dashboard')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        <span class="hide-menu">Pemilihan Pembimbing</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('Pembimbing.dashboard')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        <span class="hide-menu">Progres Bimbingan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('prodi.penilaians.index')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <span class="hide-menu">Setting Penilaian</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-home nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengajuan Ujian Mahasiswa</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('seminar-proposal.index')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <span class="hide-menu">Pengajuan Sempro</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('seminar-kompre.index')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <span class="hide-menu">Pengajuan Kompre</span>
                    </a>
                </li>
                
                <hr>
                <li class="sidebar-item bg-danger rounded-1">
                    <a class="sidebar-link text-white d-flex justify-content-center w-100" href="{{ url('logout') }}"
                        aria-expanded="false">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
@endif

@if (FiturHelper::showAdmin())
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/logo1.png') }}" width="180" alt=""
                style="margin-top: 20px; " />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-home nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link"
                        href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}"
                        aria-expanded="false">
                        <span>
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('admin.users')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="hide-menu">Pengguna</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.ruangans') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-chalkboard"></i>
                        </span>
                        <span class="hide-menu">Ruangan</span>
                    </a>
  
                <hr>
                <li class="sidebar-item bg-danger rounded-1">
                    <a class="sidebar-link text-white d-flex justify-content-center w-100" href="{{ url('logout') }}"
                        aria-expanded="false">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
@endif

@if (FiturHelper::showMahasiswa())
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('mahasiswadashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/logo1.png') }}" width="180" alt=""
                    style="margin-top: 20px; " />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-home nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('mahasiswadashboard') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}"
                        aria-expanded="false">
                        <span>
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('mahasiswa_halamanPemilihan') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        <span class="hide-menu">Pemilihan Pembimbing</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('lihat.pembimbing') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-user-friends"></i>
                        </span>
                        <span class="hide-menu">Pembimbing</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('mahasiswa_input_bimbingan') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-comments"></i>
                        </span>
                        <span class="hide-menu">Konsultasi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('mahasiswa_input_judul')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="hide-menu">Tugas Akhir</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('mahasiswa_input_logbook')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-book-open"></i>
                        </span>
                        <span class="hide-menu">Logbook Tugas Akhir</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-home nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengujian Skripsi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('mahasiswa_create_proposal')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="hide-menu">Seminar Proposal</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('mahasiswa_nilai_kompre')}}" aria-expanded="false">
                        <span>
                        <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                        <span class="hide-menu">Seminar komprehensif</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-home nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Penilaian Skripsi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('mahasiswa_nilai_proposal')}}" aria-expanded="false">
                        <span>
                        <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                        <span class="hide-menu">Seminar Proposal</span>
                    </a>
                </li>     
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('mahasiswa_hasil_kompre')}}" aria-expanded="false">
                        <span>
                        <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                        <span class="hide-menu">Seminar komprehensif</span>
                    </a>
                </li>
                
                <hr>
                
                <li class="sidebar-item bg-danger rounded-1">
                    <a class="sidebar-link text-white d-flex justify-content-center w-100" href="{{ url('logout') }}"
                        aria-expanded="false">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
@endif

@if (FiturHelper::showDosen())
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dosendashboard') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logos/logo1.png') }}" width="180" alt="" style="margin-top: 20px;" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <span class="hide-menu">Home</span>
                </li>
        
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dosendashboard') }}"
                        aria-expanded="false">
                        <span>
                            <i class="fas fa-tachometer-alt"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('profile') }}"
                        aria-expanded="false">
                        <span>
                            <i class="fas fa-user"></i>
                        </span>
                        <span class="hide-menu">Profile</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="fas fa-user-graduate nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pembimbingan Mahasiswa</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('dosen_pembimbing.students')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-users"></i>
                        </span>
                        <span class="hide-menu">Mahasiswa Bimbingan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('dosen.konsultasi.index')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-comments"></i>
                        </span>
                        <span class="hide-menu">Konsultasi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('dosen_pengajuan_judul')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-file-signature"></i>
                        </span>
                        <span class="hide-menu">Pengajuan Judul</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('dosen.logbook.index')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-book"></i>
                        </span>
                        <span class="hide-menu">Pengajuan Logbook</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="fas fa-calendar-alt nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Pengajuan Seminar</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('dosen_semprovalidasi')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-clipboard-list"></i>
                        </span>
                        <span class="hide-menu">Pengajuan Sempro</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dosen_semkomvalidasi') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-clipboard-check"></i>
                        </span>
                        <span class="hide-menu">Pengajuan Kompre</span>
                    </a>
                </li>
                
                <li class="nav-small-cap">
                    <i class="fas fa-chalkboard-teacher nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Penilaian Seminar </span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{route('dosen_seminarproposals.index')}}" aria-expanded="false">
                        <span>
                            <i class="fas fa-file-signature"></i>
                        </span>
                        <span class="hide-menu">Seminar Proposal</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dosen_seminarkomprehensif.index') }}" aria-expanded="false">
                        <span>
                            <i class="fas fa-file-signature"></i>
                        </span>
                        <span class="hide-menu">Pengajuan Kompre</span>
                    </a>
                </li>
                <hr>
                <li class="sidebar-item bg-danger rounded-1">
                    <a class="sidebar-link text-white d-flex justify-content-center w-100" href="{{ url('logout') }}"
                        aria-expanded="false">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
@endif
