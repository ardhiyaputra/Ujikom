<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Pengaduan Sekolah')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #3b5ccc;
            --secondary-color: #6b7280;
            --success-color: #2f9e8f;
            --danger-color: #c94a4a;
            --warning-color: #d4a017;
            --info-color: #3aa7b3;
        }
        
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(
                180deg,
                #3b5ccc 0%,
                #2f4bb3 100%
            );
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,.85);
            padding: 1rem;
            border-radius: 0.4rem;
            margin: 0.2rem 0;
            transition: all 0.2s ease;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,.12);
            color: #ffffff;
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,.22);
            color: #ffffff;
        }
        
        .card {
            border: none;
            border-radius: 0.6rem;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #2f4bb3;
            border-color: #2a43a5;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>
