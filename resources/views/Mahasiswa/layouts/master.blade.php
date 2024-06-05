<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-2 d-flex flex-column bg-dark vh-100">
                    <img src="{{asset('assets/login_logo.png')}}" alt="Logo" class="img-fluid" style="width: 150px;">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('halamanDashboard') }}" class="nav-link text-light d-flex align-items-center">
                                <i class="fas fa-home" style="margin-right: 27px"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('halamanKonsultasi') }}" class="nav-link text-light d-flex align-items-center">
                                <i class="fas fa-comment-dots" style="margin-right: 30px"></i>
                                <span>Konsultasi</span>           
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-light d-flex align-items-center">
                                <i class="far fa-calendar-alt" style="margin-right: 30px"></i>
                                <span>Tanggal Penting</span> 
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-light d-flex align-items-center">
                                <i class="fas fa-user-graduate" style="margin-right: 30px"></i>
                                <span>Data Mahasiswa</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-light d-flex align-items-center">
                                <i class="fas fa-chalkboard-teacher" style="margin-right: 26px"></i>
                                <span>Data Dosen</span> 
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-light d-flex align-items-center">
                                <i class="fas fa-book-open" style="margin-right: 28px"></i>
                                <span>Pengajuan TA</span> 
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-light d-flex align-items-center">
                                <i class="fas fa-clipboard-list" style="margin-right: 32px"></i>
                                <span>Logbook</span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link text-light d-flex align-items-center">
                                <i class="fas fa-file-alt" style="margin-right: 30px"></i>
                                <span>Dokumen</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="col-10 p-3 d-flex flex-column">
                    <div class="card bg-info" style="height: 50px">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="dropdown" style="position: absolute; top: 10px; right: 10px; margin-top: -10px">
                                        <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none;">
                                            <i class="fas fa-user-circle" style="font-size: 36px; border-radius: 50%;"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#">Profil</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="#">Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4 flex-grow-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4 bg-info">
                        <div class="card-body" style="margin-top: auto; height: 40px">
                            <div class="row">
                                <h5 class="mb-0 large text-dark text-center" style="margin-top: -10px">Copyright ©SINTA 2024</h5>
                            </div>
                        </div>
                    </div>
                </div>         
            </div>
        </div>
    </header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
