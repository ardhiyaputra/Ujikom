@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    <!-- Sidebar -->
    <div class="sidebar text-white p-3" style="width: 280px; position: fixed; height: 100vh; overflow-y: auto;">
        <div class="text-center mb-4 py-3">
            <div class="admin-avatar mb-3">
                <i class="bi bi-shield-check" style="font-size: 4rem;"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ Auth::guard('admin')->user()->nama }}</h5>
            <small class="text-white-50">Administrator</small>
        </div>
        
        <hr class="bg-white opacity-25">
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link" href="{{ route('admin.aspirasi.index') }}">
                <i class="bi bi-megaphone"></i> Kelola Aspirasi
            </a>
            <a class="nav-link" href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
            <a class="nav-link" href="{{ route('admin.laporan.index') }}">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>
        </nav>
        
        <hr class="bg-white opacity-25 mt-4">
        
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
    
    <!-- Main Content -->
    <div class="flex-grow-1 p-4" style="margin-left: 280px;">
        <div class="container-fluid">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="h3 mb-1 text-gray-800 fw-bold">
                    <i class="bi bi-speedometer2 text-primary"></i> Dashboard Admin
                </h1>
                <p class="text-muted mb-0">Selamat datang, {{ Auth::guard('admin')->user()->nama }}!</p>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs text-white-50 text-uppercase mb-1">Total Aspirasi</div>
                                    <div class="h2 mb-0 fw-bold">{{ $totalAspirasi }}</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs text-white-50 text-uppercase mb-1">Belum Diproses</div>
                                    <div class="h2 mb-0 fw-bold">{{ $belumDiproses }}</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs text-white-50 text-uppercase mb-1">Sedang Diproses</div>
                                    <div class="h2 mb-0 fw-bold">{{ $sedangDiproses }}</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-gear"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs text-white-50 text-uppercase mb-1">Selesai</div>
                                    <div class="h2 mb-0 fw-bold">{{ $selesai }}</div>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Recent Aspirasi -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="bi bi-clock-history"></i> Aspirasi Terbaru
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($recentAspirasi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Siswa</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentAspirasi as $aspirasi)
                                        <tr>
                                            <td>{{ $aspirasi->tanggal_pengaduan->format('d/m/Y') }}</td>
                                            <td>
                                                <strong>{{ $aspirasi->nama_siswa }}</strong><br>
                                                <small class="text-muted">{{ $aspirasi->kelas }}</small>
                                            </td>
                                            <td>{{ Str::limit($aspirasi->judul_pengaduan, 30) }}</td>
                                            <td>
                                                @if($aspirasi->status == 'Belum Diproses')
                                                <span class="badge bg-warning text-dark">Belum Diproses</span>
                                                @elseif($aspirasi->status == 'Sedang Diproses')
                                                <span class="badge bg-info">Sedang Diproses</span>
                                                @else
                                                <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.aspirasi.show', $aspirasi->id) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">Belum ada aspirasi</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Aspirasi per Kategori -->
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="bi bi-pie-chart"></i> Aspirasi per Kategori
                            </h6>
                        </div>
                        <div class="card-body">
                            @foreach($aspirasiPerKategori as $kategori)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small fw-bold">{{ $kategori->nama_kategori }}</span>
                                    <span class="small fw-bold">{{ $kategori->aspirasis_count }}</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" 
                                         style="width: {{ $totalAspirasi > 0 ? ($kategori->aspirasis_count / $totalAspirasi * 100) : 0 }}%">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%); }
    .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%); }
    .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%); }

    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.3;
    }

    .progress {
        border-radius: 10px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 10px;
    }
</style>
@endpush
@endsection