<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <img src="{{asset('assets/login_logo.png')}}" alt="Logo" class="img-fluid" style="width: 300px;">
            </div>
        </div>
        <div class="row justify-content-center" style="margin-top: -40px">
            <div class="col-md-4 border border-dark p-4 rounded">
                <p class="text-center mb-3">Welcome back! 👋</p>
                <h4 class="text-center mb-4">Login to your account</h4>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="fw-semibold mb-2" for="username" class="form-label">Username</label>
                        <input name="username" type="text" class="form-control" id="username" placeholder="Enter username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold mb-2" for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                </form>
                @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
        </div>
    </div>
</body>
</html>
