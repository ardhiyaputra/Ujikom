@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="d-flex" style="min-height: 100vh;">
    <!-- Sidebar -->
    <div class="sidebar text-white p-3" style="width: 280px; position: fixed; height: 100vh; overflow-y: auto;">
        <div class="text-center mb-4 py-3">
            <div class="user-avatar mb-3">
                <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
            </div>
            <h5 class="fw-bold mb-0">{{ session('siswa_nama') }}</h5>
            <small class="text-white-50">{{ session('siswa_kelas') }}</small>
            @if(session('siswa_email'))
            <small class="d-block text-white-50 mt-1">
                <i class="bi bi-envelope"></i> {{ session('siswa_email') }}
            </small>
            @endif
        </div>
        
        <hr class="bg-white opacity-25">
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="{{ route('siswa.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link" href="{{ route('siswa.aspirasi.create') }}">
                <i class="bi bi-plus-circle"></i> Buat Pengaduan
            </a>
            <a class="nav-link" href="{{ route('siswa.aspirasi.history') }}">
                <i class="bi bi-clock-history"></i> Histori Aspirasi
            </a>
        </nav>
        
        <hr class="bg-white opacity-25 mt-4">
        
        <form method="POST" action="{{ route('siswa.logout') }}">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800 fw-bold">Dashboard Siswa</h1>
                    <p class="text-muted mb-0">Kelola pengaduan sarana dan prasarana sekolah</p>
                </div>
                <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle"></i> Buat Pengaduan Baru
                </a>
            </div>
            
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pengaduan</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $aspirasis->count() }}</div>
                                </div>
                                <div class="stat-icon bg-primary">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Belum Diproses</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                                        {{ $aspirasis->where('status', 'Belum Diproses')->count() }}
                                    </div>
                                </div>
                                <div class="stat-icon bg-warning">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Diproses</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                                        {{ $aspirasis->where('status', 'Sedang Diproses')->count() }}
                                    </div>
                                </div>
                                <div class="stat-icon bg-info">
                                    <i class="bi bi-gear"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                                        {{ $aspirasis->where('status', 'Selesai')->count() }}
                                    </div>
                                </div>
                                <div class="stat-icon bg-success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- List Pengaduan -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-list-ul"></i> Daftar Pengaduan Saya
                    </h6>
                </div>
                <div class="card-body">
                    @if($aspirasis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="25%">Judul Pengaduan</th>
                                    <th width="15%">Kategori</th>
                                    <th width="10%">Lokasi</th>
                                    <th width="15%">Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aspirasis as $index => $aspirasi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $aspirasi->tanggal_pengaduan->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ Str::limit($aspirasi->judul_pengaduan, 40) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $aspirasi->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                    <td>{{ $aspirasi->lokasi ?? '-' }}</td>
                                    <td>
                                        @if($aspirasi->status == 'Belum Diproses')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-hourglass-split"></i> Belum Diproses
                                        </span>
                                        @elseif($aspirasi->status == 'Sedang Diproses')
                                        <span class="badge bg-info">
                                            <i class="bi bi-gear"></i> Sedang Diproses
                                        </span>
                                        @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('siswa.aspirasi.show', $aspirasi->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if($aspirasi->status == 'Belum Diproses')
                                        <a href="{{ route('siswa.aspirasi.edit', $aspirasi->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('siswa.aspirasi.destroy', $aspirasi->id) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                        <h5 class="mt-3 text-muted">Belum Ada Pengaduan</h5>
                        <p class="text-muted">Anda belum membuat pengaduan apapun</p>
                        <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Buat Pengaduan Sekarang
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endpush
@endsection