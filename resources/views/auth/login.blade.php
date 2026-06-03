<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Blog CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .card-header { background-color: transparent; border-bottom: none; text-align: center; padding-top: 2rem; }
        .card-body { padding: 2rem; }
        .btn-primary { background-color: #3b5bdb; border-color: #3b5bdb; }
        .btn-primary:hover { background-color: #364fc7; border-color: #364fc7; }
        .form-control:focus { border-color: #3b5bdb; box-shadow: 0 0 0 0.25rem rgba(59, 91, 219, 0.25); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-1">Blog CMS</h5>
                        <p class="text-muted small mb-0">Masukkan kredensial untuk melanjutkan</p>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $errors->first('user_name') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="user_name" class="form-label">Username</label>
                                <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                       id="user_name" name="user_name" value="{{ old('user_name') }}"
                                       placeholder="Masukkan username" autofocus>
                                @error('user_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" placeholder="Masukkan password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
