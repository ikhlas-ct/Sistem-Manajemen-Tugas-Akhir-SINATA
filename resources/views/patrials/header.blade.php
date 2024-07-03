<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                        <i class="ti ti-bell-ringing"></i>
                        <div class="notification bg-primary rounded-circle"></div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
    
                        <span class="profile-name ms-2">Hai, {{ \App\Helpers\FiturHelper::ambilnamauser() }}</span>
                        <i class="fas fa-caret-down ms-3 me-3"></i>
                        <img src="{{ \App\Helpers\FiturHelper::getProfileImage() }}" alt="Profile Image" width="35" height="35" class="rounded-circle ms-2">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <li>
                            <a href="{{ route('profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">My Account</p>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-list-check fs-6"></i>
                                <p class="mb-0 fs-3">My Task</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    

</header>
