@extends('layouts.app')

@section('title', 'Laporan Aspirasi')

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
            <a class="nav-link" href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
            <a class="nav-link active" href="{{ route('admin.laporan.index') }}">
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
                    <i class="bi bi-file-earmark-bar-graph text-primary"></i> Generate Laporan
                </h1>
                <p class="text-muted mb-0">Buat laporan aspirasi berdasarkan filter tertentu</p>
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

            <div class="row">
                <!-- Form Generate Laporan -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-sliders"></i> Filter Laporan
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.laporan.generate') }}" method="POST" target="_blank">
                                @csrf
                                
                                <!-- Periode Tanggal -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h6 class="fw-bold text-primary mb-3">
                                            <i class="bi bi-calendar-range"></i> Periode Laporan
                                        </h6>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Tanggal Dari <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" 
                                               class="form-control form-control-lg @error('tanggal_dari') is-invalid @enderror" 
                                               name="tanggal_dari" 
                                               value="{{ old('tanggal_dari') }}" 
                                               required>
                                        @error('tanggal_dari')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Tanggal Sampai <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" 
                                               class="form-control form-control-lg @error('tanggal_sampai') is-invalid @enderror" 
                                               name="tanggal_sampai" 
                                               value="{{ old('tanggal_sampai') }}" 
                                               required>
                                        @error('tanggal_sampai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Filter Kategori -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h6 class="fw-bold text-primary mb-3">
                                            <i class="bi bi-tags"></i> Filter Kategori
                                        </h6>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Kategori</label>
                                        <select class="form-select form-select-lg @error('kategori_id') is-invalid @enderror" 
                                                name="kategori_id">
                                            <option value="">Semua Kategori</option>
                                            @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama_kategori }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            <i class="bi bi-info-circle"></i> Kosongkan jika ingin semua kategori
                                        </small>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Filter Status -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <h6 class="fw-bold text-primary mb-3">
                                            <i class="bi bi-check-circle"></i> Filter Status
                                        </h6>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Status Penyelesaian</label>
                                        <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                                name="status">
                                            <option value="">Semua Status</option>
                                            <option value="Belum Diproses" {{ old('status') == 'Belum Diproses' ? 'selected' : '' }}>
                                                Belum Diproses
                                            </option>
                                            <option value="Sedang Diproses" {{ old('status') == 'Sedang Diproses' ? 'selected' : '' }}>
                                                Sedang Diproses
                                            </option>
                                            <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>
                                                Selesai
                                            </option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            <i class="bi bi-info-circle"></i> Kosongkan jika ingin semua status
                                        </small>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-file-earmark-pdf"></i> Generate Laporan
                                    </button>
                                    <button type="reset" class="btn btn-secondary btn-lg">
                                        <i class="bi bi-arrow-clockwise"></i> Reset Filter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Info & Panduan -->
                <div class="col-lg-4">
                    <!-- Quick Stats -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="bi bi-info-circle"></i> Informasi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Format Laporan</small>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-pdf text-danger me-2" style="font-size: 1.5rem;"></i>
                                    <strong>PDF (Portable Document Format)</strong>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Orientasi</small>
                                <strong>Portrait (Vertikal)</strong>
                            </div>
                            
                            <hr>
                            
                            <div>
                                <small class="text-muted d-block mb-1">Ukuran Kertas</small>
                                <strong>A4 (210mm x 297mm)</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Panduan -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="bi bi-lightbulb"></i> Panduan
                            </h6>
                        </div>
                        <div class="card-body">
                            <ol class="mb-0 ps-3">
                                <li class="mb-2">Pilih <strong>periode tanggal</strong> yang ingin dilaporkan</li>
                                <li class="mb-2">Pilih <strong>kategori</strong> (opsional)</li>
                                <li class="mb-2">Pilih <strong>status</strong> penyelesaian (opsional)</li>
                                <li class="mb-2">Klik tombol <strong>"Generate Laporan"</strong></li>
                                <li class="mb-0">Laporan akan terbuka di tab baru</li>
                            </ol>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card border-0 shadow-sm bg-gradient-info text-white">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-star"></i> Tips Laporan
                            </h6>
                            <ul class="mb-0 ps-3 small">
                                <li class="mb-2">Gunakan filter kategori untuk laporan spesifik</li>
                                <li class="mb-2">Filter status untuk melihat progres penyelesaian</li>
                                <li class="mb-2">Periode maksimal 1 tahun untuk performa optimal</li>
                                <li class="mb-0">Laporan dapat langsung dicetak atau disimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Laporan Preview -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="bi bi-eye"></i> Preview Template Laporan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-4">
                                <i class="bi bi-file-earmark-text" style="font-size: 5rem; color: #ccc;"></i>
                                <h5 class="mt-3 text-muted">Laporan Aspirasi Sarana Sekolah</h5>
                                <p class="text-muted">Generate laporan untuk melihat preview</p>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="10%">Tanggal</th>
                                            <th width="15%">Siswa</th>
                                            <th width="25%">Judul Pengaduan</th>
                                            <th width="15%">Kategori</th>
                                            <th width="15%">Lokasi</th>
                                            <th width="15%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>01/01/2025</td>
                                            <td>
                                                <strong>Nama Siswa</strong><br>
                                                <small class="text-muted">XII PPLG 1</small>
                                            </td>
                                            <td>Contoh Judul Pengaduan</td>
                                            <td>Ruang Kelas</td>
                                            <td>Lantai 2</td>
                                            <td>
                                                <span class="badge bg-success">Selesai</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <em>Data contoh - Generate laporan untuk melihat data sesungguhnya</em>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control-lg,
    .form-select-lg {
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .btn-lg {
        padding: 0.875rem 2rem;
        font-size: 1.1rem;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3);
    }

    .card {
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    hr {
        border-top: 2px dashed #e9ecef;
    }
</style>
@endpush

@push('scripts')
<script>
    // Set default dates (current month)
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        const tanggalDari = document.querySelector('input[name="tanggal_dari"]');
        const tanggalSampai = document.querySelector('input[name="tanggal_sampai"]');
        
        if (!tanggalDari.value) {
            tanggalDari.value = firstDay.toISOString().split('T')[0];
        }
        
        if (!tanggalSampai.value) {
            tanggalSampai.value = lastDay.toISOString().split('T')[0];
        }
    });

    // Validate date range
    document.querySelector('form').addEventListener('submit', function(e) {
        const tanggalDari = new Date(document.querySelector('input[name="tanggal_dari"]').value);
        const tanggalSampai = new Date(document.querySelector('input[name="tanggal_sampai"]').value);
        
        if (tanggalSampai < tanggalDari) {
            e.preventDefault();
            alert('Tanggal sampai harus lebih besar atau sama dengan tanggal dari!');
            return false;
        }
    });
</script>
@endpush
@endsection