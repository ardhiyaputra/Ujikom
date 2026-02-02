@extends('layouts.app')

@section('title', 'Detail Aspirasi')

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
                        <i class="bi bi-file-text text-primary"></i> Detail Aspirasi
                    </h1>
                    <p class="text-muted mb-0">Informasi lengkap pengaduan siswa</p>
                </div>
                <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="row">
                <!-- Detail Aspirasi -->
                <div class="col-lg-8 mb-4">
                    <!-- Info Pengaduan -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-info-circle"></i> Informasi Pengaduan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Nama Siswa</label>
                                    <p class="fw-bold mb-0">{{ $aspirasi->nama_siswa }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Kelas</label>
                                    <p class="fw-bold mb-0">{{ $aspirasi->kelas }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Email</label>
                                    <p class="fw-bold mb-0">{{ $aspirasi->email ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Tanggal Pengaduan</label>
                                    <p class="fw-bold mb-0">{{ $aspirasi->tanggal_pengaduan->format('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="text-muted small">Kategori</label>
                                    <p class="mb-0">
                                        <span class="badge bg-secondary">{{ $aspirasi->kategori->nama_kategori }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Lokasi</label>
                                    <p class="fw-bold mb-0">{{ $aspirasi->lokasi ?? '-' }}</p>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="text-muted small">Judul Pengaduan</label>
                                <h5 class="fw-bold">{{ $aspirasi->judul_pengaduan }}</h5>
                            </div>

                            <div>
                                <label class="text-muted small">Deskripsi Pengaduan</label>
                                <p class="text-justify" style="white-space: pre-line;">{{ $aspirasi->deskripsi_pengaduan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Umpan Balik -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="bi bi-chat-left-text"></i> Umpan Balik ({{ $aspirasi->umpanBaliks->count() }})
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($aspirasi->umpanBaliks->count() > 0)
                                @foreach($aspirasi->umpanBaliks as $umpanBalik)
                                <div class="umpan-balik-item mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <strong class="text-primary">
                                                <i class="bi bi-person-badge"></i> {{ $umpanBalik->admin->nama }}
                                            </strong>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-calendar3"></i> {{ $umpanBalik->tanggal_umpan_balik->format('d F Y, H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <p class="mb-0" style="white-space: pre-line;">{{ $umpanBalik->isi_umpan_balik }}</p>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted text-center py-4">
                                    <i class="bi bi-chat-left-dots" style="font-size: 3rem; color: #ccc;"></i><br>
                                    Belum ada umpan balik
                                </p>
                            @endif

                            <!-- Form Tambah Umpan Balik -->
                            <hr class="my-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-plus-circle"></i> Tambah Umpan Balik
                            </h6>
                            <form action="{{ route('admin.aspirasi.storeUmpanBalik', $aspirasi->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control @error('isi_umpan_balik') is-invalid @enderror" 
                                              name="isi_umpan_balik" 
                                              rows="4" 
                                              placeholder="Tulis umpan balik Anda..." 
                                              required></textarea>
                                    @error('isi_umpan_balik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Kirim Umpan Balik
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="col-lg-4">
                    <!-- Update Status -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="bi bi-gear"></i> Status Pengaduan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 text-center">
                                <label class="text-muted small d-block mb-2">Status Saat Ini</label>
                                @if($aspirasi->status == 'Belum Diproses')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-hourglass-split"></i> Belum Diproses
                                </span>
                                @elseif($aspirasi->status == 'Sedang Diproses')
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-gear"></i> Sedang Diproses
                                </span>
                                @else
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                                @endif
                            </div>

                            <hr>

                            <form action="{{ route('admin.aspirasi.updateStatus', $aspirasi->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ubah Status</label>
                                    <select name="status" class="form-select" required>
                                        <option value="Belum Diproses" {{ $aspirasi->status == 'Belum Diproses' ? 'selected' : '' }}>
                                            Belum Diproses
                                        </option>
                                        <option value="Sedang Diproses" {{ $aspirasi->status == 'Sedang Diproses' ? 'selected' : '' }}>
                                            Sedang Diproses
                                        </option>
                                        <option value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-save"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Info Timeline -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary">
                                <i class="bi bi-clock-history"></i> Timeline
                            </h6>
                        </div>
                        <div class="card-body">
                            <small class="text-muted d-block mb-2">Dibuat</small>
                            <p class="fw-bold mb-3">{{ $aspirasi->created_at->format('d F Y, H:i') }}</p>

                            <small class="text-muted d-block mb-2">Terakhir Diupdate</small>
                            <p class="fw-bold mb-0">{{ $aspirasi->updated_at->format('d F Y, H:i') }}</p>
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

    .umpan-balik-item {
        background-color: #f8f9fc;
        transition: all 0.3s ease;
    }

    .umpan-balik-item:hover {
        background-color: #eaecf4;
        transform: translateX(5px);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush
@endsection