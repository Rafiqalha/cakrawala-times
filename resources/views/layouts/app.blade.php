<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cakrawala Times Admin')</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Material Icons (opsional) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Material 3 Surface */
            color: #1f1f1f;
        }
        /* Top App Bar (Navbar) */
        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* M3 Elevation 1 */
            padding-top: 12px;
            padding-bottom: 12px;
        }
        .navbar-brand {
            color: #1f1f1f !important;
            font-weight: 500;
            font-size: 1.25rem;
            letter-spacing: 0.15px;
        }
        /* Sidebar Navigation */
        .sidebar {
            background-color: #f3f4f6; /* Menyatu dengan background body */
            min-height: 100vh;
            padding-top: 24px;
            border-right: none;
        }
        .nav-link {
            color: #444746 !important;
            border-radius: 100px; /* Bentuk Pill khas Material 3 */
            padding: 14px 24px;
            margin-bottom: 4px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .nav-link:hover {
            background-color: #e1e3e1; /* Hover tonal M3 */
            color: #1d1b20 !important;
        }
        .nav-link.active {
            background-color: #c2e7ff !important; /* M3 Primary Container (Google Blue Light) */
            color: #001d35 !important; /* M3 On Primary Container */
            font-weight: 600;
        }
        /* Cards */
        .card {
            border: none;
            border-radius: 16px; /* Standar Radius M3 */
            box-shadow: 0 1px 3px rgba(0,0,0,0.12); /* Elevation tipis */
            background-color: #ffffff;
            margin-bottom: 24px;
            overflow: hidden;
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e1e3e1;
            padding: 16px 20px;
            font-weight: 500;
            font-size: 1.1rem;
        }
        /* Profile Section in Sidebar */
        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0 16px 32px 16px;
        }
        .profile-section img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15); /* Bayangan sedikit untuk memberi kesan timbul */
        }
        .profile-section h6 {
            font-weight: 500;
            color: #1f1f1f;
            margin-bottom: 4px;
            letter-spacing: 0.1px;
        }
        .profile-section small {
            color: #444746;
        }
        /* Buttons */
        .btn-outline-danger {
            border-radius: 100px; /* Bentuk pill */
            font-weight: 500;
            padding: 8px 24px;
            letter-spacing: 0.1px;
        }
        .btn-primary {
            background-color: #0b57d0; /* M3 Primary Blue */
            border-color: #0b57d0;
            border-radius: 100px;
            font-weight: 500;
            padding: 10px 24px;
        }
        .btn-primary:hover {
            background-color: #0842a0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }
        /* Flash Message */
        .alert {
            border-radius: 12px;
            border: none;
        }

        /* Modern Table (Material 3 Style) */
        .table-custom {
            margin-bottom: 0;
        }
        .table-custom thead th {
            border-bottom: 1px solid #e0e0e0;
            border-top: none;
            color: #444746;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px;
            background-color: transparent;
        }
        .table-custom tbody td {
            vertical-align: middle;
            padding: 16px;
            border-bottom: 1px solid #f0f4f9;
            color: #1f1f1f;
        }
        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }
        .table-custom tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Action Buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background-color: transparent;
            transition: all 0.2s;
            color: #444746;
        }
        .btn-action:hover {
            background-color: #f0f4f9;
        }
        .btn-action.edit:hover {
            background-color: #e8f0fe;
            color: #0b57d0;
        }
        .btn-action.delete:hover {
            background-color: #fce8e6;
            color: #c5221f;
        }
        /* Formulir */
        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #747775; /* M3 Outline */
        }
        .form-control:focus {
            border-color: #0b57d0;
            box-shadow: inset 0 0 0 1px #0b57d0; /* M3 Focus State */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <!-- Optional: Use a material icon here -->
                <span class="material-icons-outlined align-middle me-2" style="color: #0b57d0;">language</span>
                Cakrawala Times
            </a>
            <div class="d-flex align-items-center">
                <span class="me-4 fw-medium" style="color: #444746;">{{ Auth::user()->nama_lengkap }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar px-3">
                <div class="profile-section">
                    @php
                        $foto = Auth::user()->foto ? Auth::user()->foto : 'default.png';
                    @endphp
                    <img src="{{ asset('storage/foto/' . $foto) }}" alt="Foto Profil">
                    <h6>{{ Auth::user()->nama_lengkap }}</h6>
                    <small>Administrator</small>
                </div>
                <ul class="nav flex-column px-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <span class="material-icons-outlined align-middle me-2">dashboard</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                            <span class="material-icons-outlined align-middle me-2">category</span> Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('penulis.*') ? 'active' : '' }}" href="{{ route('penulis.index') }}">
                            <span class="material-icons-outlined align-middle me-2">group</span> Penulis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('artikel.*') ? 'active' : '' }}" href="{{ route('artikel.index') }}">
                            <span class="material-icons-outlined align-middle me-2">edit_note</span> Artikel
                        </a>
                    </li>
                </ul>
            </div>
            <main class="col-md-10 p-4">
                @if(session('success'))
                    <div class="alert alert-dismissible fade show border-0 shadow-sm" style="border-radius: 12px; background-color: #d3e3fd; color: #041e49;" role="alert">
                        <span class="material-icons-outlined align-middle me-2">check_circle</span>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-dismissible fade show border-0 shadow-sm" style="border-radius: 12px; background-color: #f9dedc; color: #410e0b;" role="alert">
                        <span class="material-icons-outlined align-middle me-2">error</span>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
                
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
