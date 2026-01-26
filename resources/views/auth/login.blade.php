@extends('layouts.app')

@section('title', 'Login - Pengaduan Sekolah')

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                
                <div class="card login-card border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row g-0">
                        
                            <div class="col-lg-6 d-none d-lg-flex bg-login-image">
                                <div class="login-illustration">
                                    <div class="illustration-content">
                                        <div class="icon-wrapper">
                                            <i class="bi bi-megaphone"></i>
                                            <div class="icon-circle"></div>
                                            <div class="icon-circle-2"></div>
                                        </div>
                                        <h3 class="mt-4 fw-bold animate-text">Aplikasi Pengaduan<br>Sarana Sekolah</h3>
                                        <p class="mt-3 animate-text-delay">Sampaikan aspirasimu untuk sekolah yang lebih baik!</p>
                                        <div class="floating-shapes">
                                            <div class="shape shape-1"></div>
                                            <div class="shape shape-2"></div>
                                            <div class="shape shape-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="p-5 form-section">
                                    
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
                                        <i class="bi bi-check-circle-fill"></i> 
                                        <span>{{ session('success') }}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                    @endif
                                    
                                    @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
                                        <i class="bi bi-exclamation-triangle-fill"></i> 
                                        <span>{{ session('error') }}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                    @endif
                                    
                                    <div class="text-center mb-4 header-section">
                                        <div class="logo-badge">
                                            <i class="bi bi-shield-check"></i>
                                        </div>
                                        <h1 class="h3 text-gray-900 mb-2 fw-bold">Selamat Datang!</h1>
                                        <p class="text-muted">Silakan pilih jenis login Anda</p>
                                    </div>

                                    <ul class="nav nav-pills custom-tabs mb-4" id="loginTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="siswa-tab" data-bs-toggle="pill" data-bs-target="#siswa" type="button" role="tab">
                                                <i class="bi bi-person-circle"></i>
                                                <span>Siswa</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="admin-tab" data-bs-toggle="pill" data-bs-target="#admin" type="button" role="tab">
                                                <i class="bi bi-shield-lock-fill"></i>
                                                <span>Admin</span>
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="loginTabContent">
                                        
                                        <div class="tab-pane fade show active" id="siswa" role="tabpanel">
                                            <form method="POST" action="{{ route('login.siswa') }}" class="custom-form">
                                                @csrf
                                                
                                                <div class="mb-3 form-group-custom">
                                                    <label class="form-label">
                                                        <i class="bi bi-person"></i> Nama Lengkap
                                                    </label>
                                                    <input type="text" class="form-control custom-input @error('nama_siswa') is-invalid @enderror" 
                                                           name="nama_siswa" placeholder="Masukkan nama lengkap" 
                                                           value="{{ old('nama_siswa') }}" required>
                                                    @error('nama_siswa')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3 form-group-custom">
                                                    <label class="form-label">
                                                        <i class="bi bi-book"></i> Kelas
                                                    </label>
                                                    <select class="form-select custom-input @error('kelas') is-invalid @enderror" name="kelas" required>
                                                        <option value="">Pilih Kelas</option>
                                                        <option value="X PPLG">X PPLG</option>
                                                        <option value="X TJKT 1">X TJKT 1</option>
                                                        <option value="X TJKT 2">X TJKT 2</option>
                                                        <option value="X AKL">X AKL</option>
                                                        <option value="X ACP">X ACP</option>
                                                        <option value="XI AKL">XI AKL</option>
                                                        <option value="XI PPLG">XI PPLG</option>
                                                        <option value="XI TJKT 1">XI TJKT 1</option>
                                                        <option value="XI TJKT 2">XI TJKT 2</option>
                                                        <option value="XI ACP">XI ACP</option>
                                                        <option value="XII PPLG 1">XII PPLG 1</option>
                                                        <option value="XII PPLG 2">XII PPLG 2</option>
                                                        <option value="XII TJKT 1">XII TJKT 1</option>
                                                        <option value="XII TJKT 2">XII TJKT 2</option>
                                                        <option value="XII AKL">XII AKL</option>
                                                        <option value="XII ACP">XII ACP</option>
                                                    </select>
                                                    @error('kelas')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-4 form-group-custom">
                                                    <label class="form-label">
                                                        <i class="bi bi-envelope"></i> Email <span class="text-muted">(Opsional)</span>
                                                    </label>
                                                    <input type="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                                                           name="email" placeholder="contoh@email.com" 
                                                           value="{{ old('email') }}">
                                                    @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary custom-btn w-100">
                                                    <span>Masuk sebagai Siswa</span>
                                                    <i class="bi bi-arrow-right-circle"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="admin" role="tabpanel">
                                            <form method="POST" action="{{ route('login.admin') }}" class="custom-form">
                                                @csrf
                                                
                                                <div class="mb-3 form-group-custom">
                                                    <label class="form-label">
                                                        <i class="bi bi-person-badge"></i> Username
                                                    </label>
                                                    <input type="text" class="form-control custom-input @error('username') is-invalid @enderror" 
                                                           name="username" placeholder="Masukkan username" 
                                                           value="{{ old('username') }}" required>
                                                    @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-4 form-group-custom">
                                                    <label class="form-label">
                                                        <i class="bi bi-lock"></i> Password
                                                    </label>
                                                    <input type="password" class="form-control custom-input @error('password') is-invalid @enderror" 
                                                           name="password" placeholder="Masukkan password" required>
                                                    @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary custom-btn w-100">
                                                    <span>Masuk sebagai Admin</span>
                                                    <i class="bi bi-shield-check"></i>
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4f5bd5 0%, #5f4c8b 100%);
        --primary-color: #4f5bd5;
        --primary-dark: #434fc0;
        --secondary-color: #5f4c8b;
        --accent-color: #9a8bbd;

        --success-color: #2f9e8f;
        --danger-color: #c94a4a;

        --text-dark: #1f2937;
        --text-light: #6b7280;
        --bg-light: #f4f6f9;

        --shadow-sm: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.05);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.08), 0 4px 6px rgba(0,0,0,0.04);
        --shadow-xl: 0 20px 25px rgba(0,0,0,0.08), 0 10px 10px rgba(0,0,0,0.03);
    }

    .login-wrapper {
        background: linear-gradient(
            135deg,
            #4f5bd5 0%,
            #5f4c8b 50%,
            #7a6fa3 100%
        );
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        position: relative;
        overflow: hidden;
    }

    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .login-card {
        border-radius: 20px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        animation: cardFadeIn 0.8s ease;
    }

    @keyframes cardFadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .bg-login-image {
        background: var(--primary-gradient);
        position: relative;
        overflow: hidden;
    }

    .login-illustration {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
    }

    .illustration-content {
        text-align: center;
        color: white;
        padding: 2rem;
        position: relative;
    }

    .icon-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .icon-wrapper i {
        font-size: 5rem;
        position: relative;
        z-index: 2;
        animation: iconFloat 3s ease-in-out infinite;
    }

    @keyframes iconFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .icon-circle, .icon-circle-2 {
        position: absolute;
        border-radius: 50%;
        border: 2px solid rgba(255,255,255,0.25);
    }

    .icon-circle {
        width: 100px;
        height: 100px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: pulse 2s ease-in-out infinite;
    }

    .icon-circle-2 {
        width: 130px;
        height: 130px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: pulse 2s ease-in-out infinite 0.5s;
    }

    @keyframes pulse {
        0%, 100% { 
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
        50% { 
            transform: translate(-50%, -50%) scale(1.08);
            opacity: 0.5;
        }
    }

    .shape {
        background: rgba(255,255,255,0.08);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-label i {
        color: var(--primary-color);
    }

    .custom-input {
        border: 2px solid #e5e7eb;
    }

    .custom-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(79, 91, 213, 0.12);
    }

    .custom-btn {
        background: var(--primary-gradient);
        box-shadow: var(--shadow-md);
    }

    .alert-success {
        background: linear-gradient(135deg, #2f9e8f 0%, #248277 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, #c94a4a 0%, #b03a3a 100%);
        color: white;
    }

</style>
@endpush
@endsection
