@extends('layouts.app')

@section('title', 'Kelola Aspirasi')

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
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link active" href="{{ route('admin.aspirasi.index') }}">
                <i class="bi bi-megaphone"></i> Kelola Aspirasi
            </a>
            <a class="nav-link" href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i> Kelola Kategori
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
                    <i class="bi bi-megaphone text-primary"></i> Kelola Aspirasi
                </h1>
                <p class="text-muted mb-0">Kelola semua aspirasi dan pengaduan dari siswa</p>
            </div>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <!-- Filter Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.aspirasi.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-funnel"></i> Status
                                </label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="Belum Diproses" {{ request('status') == 'Belum Diproses' ? 'selected' : '' }}>Belum Diproses</option>
                                    <option value="Sedang Diproses" {{ request('status') == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-tags"></i> Kategori
                                </label>
                                <select name="kategori_id" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-calendar"></i> Tanggal Dari
                                </label>
                                <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-calendar"></i> Tanggal Sampai
                                </label>
                                <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                            </div>
                            
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama siswa, kelas, atau judul pengaduan..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-arrow-clockwise"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Aspirasi Table -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="bi bi-list-ul"></i> Daftar Aspirasi ({{ $aspirasis->total() }} data)
                        </h6>
                    </div>
                </div>
                <div class="card-body">
                    @if($aspirasis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="3%">No</th>
                                    <th width="8%">Tanggal</th>
                                    <th width="12%">Siswa</th>
                                    <th width="20%">Judul Pengaduan</th>
                                    <th width="10%">Kategori</th>
                                    <th width="10%">Lokasi</th>
                                    <th width="10%">Status</th>
                                    <th width="7%" class="text-center">Umpan Balik</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aspirasis as $index => $aspirasi)
                                <tr>
                                    <td>{{ $aspirasis->firstItem() + $index }}</td>
                                    <td>{{ $aspirasi->tanggal_pengaduan->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $aspirasi->nama_siswa }}</strong><br>
                                        <small class="text-muted">{{ $aspirasi->kelas }}</small>
                                    </td>
                                    <td>{{ Str::limit($aspirasi->judul_pengaduan, 40) }}</td>
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
                                        @if($aspirasi->umpanBaliks->count() > 0)
                                        <span class="badge bg-primary">{{ $aspirasi->umpanBaliks->count() }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.aspirasi.show', $aspirasi->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.aspirasi.destroy', $aspirasi->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus aspirasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $aspirasis->links() }}
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                        <h5 class="mt-3 text-muted">Tidak ada data aspirasi</h5>
                        <p class="text-muted">Belum ada aspirasi yang masuk atau sesuai filter</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
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
    
    .form-select:focus,
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush
@endsection