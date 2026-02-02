@extends('layouts.app')

@section('title', 'Kelola Kategori')

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
            <a class="nav-link" href="{{ route('admin.aspirasi.index') }}">
                <i class="bi bi-megaphone"></i> Kelola Aspirasi
            </a>
            <a class="nav-link active" href="{{ route('admin.kategori.index') }}">
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800 fw-bold">
                        <i class="bi bi-tags text-primary"></i> Kelola Kategori
                    </h1>
                    <p class="text-muted mb-0">Kelola kategori pengaduan sarana dan prasarana</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </button>
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

            <!-- Statistics Card -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block mb-1">Total Kategori</small>
                                    <h3 class="mb-0 fw-bold">{{ $kategoris->count() }}</h3>
                                </div>
                                <div class="stat-icon-bg">
                                    <i class="bi bi-tags"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block mb-1">Total Aspirasi</small>
                                    <h3 class="mb-0 fw-bold">{{ $kategoris->sum('aspirasis_count') }}</h3>
                                </div>
                                <div class="stat-icon-bg">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block mb-1">Rata-rata per Kategori</small>
                                    <h3 class="mb-0 fw-bold">
                                        {{ $kategoris->count() > 0 ? number_format($kategoris->sum('aspirasis_count') / $kategoris->count(), 1) : 0 }}
                                    </h3>
                                </div>
                                <div class="stat-icon-bg">
                                    <i class="bi bi-bar-chart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori Cards -->
            <div class="row">
                @foreach($kategoris as $kategori)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card kategori-card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="kategori-icon">
                                    <i class="bi bi-tag-fill"></i>
                                </div>
                                <span class="badge bg-primary">{{ $kategori->aspirasis_count }} Aspirasi</span>
                            </div>
                            
                            <h5 class="fw-bold mb-2">{{ $kategori->nama_kategori }}</h5>
                            <p class="text-muted small mb-3">{{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-warning flex-fill" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditKategori{{ $kategori->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" 
                                      method="POST" 
                                      class="flex-fill"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Kategori -->
                <div class="modal fade" id="modalEditKategori{{ $kategori->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-pencil-square"></i> Edit Kategori
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-tag"></i> Nama Kategori <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                                               name="nama_kategori" 
                                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                               required>
                                        @error('nama_kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-text-paragraph"></i> Deskripsi
                                        </label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                                  name="deskripsi" 
                                                  rows="3">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                        @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="alert alert-info border-0">
                                        <i class="bi bi-info-circle"></i> 
                                        Kategori ini memiliki <strong>{{ $kategori->aspirasis_count }}</strong> aspirasi
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="bi bi-save"></i> Update Kategori
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($kategoris->count() === 0)
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 5rem; color: #ccc;"></i>
                            <h4 class="mt-4 text-muted">Belum Ada Kategori</h4>
                            <p class="text-muted">Tambahkan kategori pertama untuk memulai</p>
                            <button class="btn btn-primary btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                                <i class="bi bi-plus-circle"></i> Tambah Kategori Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-tag"></i> Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               name="nama_kategori" 
                               placeholder="Contoh: Ruang Kelas" 
                               value="{{ old('nama_kategori') }}" 
                               required>
                        @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="bi bi-lightbulb"></i> Berikan nama yang jelas dan mudah dipahami
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-text-paragraph"></i> Deskripsi
                        </label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  name="deskripsi" 
                                  rows="3" 
                                  placeholder="Jelaskan kategori ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            <i class="bi bi-lightbulb"></i> Deskripsi opsional untuk membantu siswa memilih kategori
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);
    }

    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }

    .stat-icon-bg {
        font-size: 2.5rem;
        opacity: 0.3;
    }

    .kategori-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .kategori-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        border-left-color: #667eea;
    }

    .kategori-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .modal-header.bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .modal-header.bg-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%) !important;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto close alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Reopen modal if validation errors exist
    @if($errors->any())
        @if(old('_method') == 'PUT')
            // Find which edit modal should be opened based on old input
            var kategoriId = {{ old('kategori_id', 0) }};
            if(kategoriId > 0) {
                $('#modalEditKategori' + kategoriId).modal('show');
            }
        @else
            $('#modalTambahKategori').modal('show');
        @endif
    @endif
</script>
@endpush
@endsection