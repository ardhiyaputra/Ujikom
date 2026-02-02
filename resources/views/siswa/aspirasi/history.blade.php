@extends('layouts.app')

@section('title', 'Histori Aspirasi')

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
            <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link" href="{{ route('siswa.aspirasi.create') }}">
                <i class="bi bi-plus-circle"></i> Buat Pengaduan
            </a>
            <a class="nav-link active" href="{{ route('siswa.aspirasi.history') }}">
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
                    <h1 class="h3 mb-1 text-gray-800 fw-bold">
                        <i class="bi bi-clock-history text-primary"></i> Histori Aspirasi
                    </h1>
                    <p class="text-muted mb-0">Riwayat pengaduan yang telah Anda kirimkan</p>
                </div>
                <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Pengaduan Baru
                </a>
            </div>

            <!-- Filter & Search -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-funnel"></i> Filter Status
                            </label>
                            <select class="form-select" id="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="Belum Diproses">Belum Diproses</option>
                                <option value="Sedang Diproses">Sedang Diproses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-calendar"></i> Filter Bulan
                            </label>
                            <select class="form-select" id="filterBulan">
                                <option value="">Semua Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">
                                <i class="bi bi-search"></i> Cari Pengaduan
                            </label>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari judul atau deskripsi...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-secondary w-100" onclick="resetFilter()">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Summary -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block mb-1">Total Pengaduan</small>
                                    <h3 class="mb-0 fw-bold">{{ $aspirasis->count() }}</h3>
                                </div>
                                <div class="stat-icon-bg">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block mb-1">Belum Diproses</small>
                                    <h3 class="mb-0 fw-bold">{{ $aspirasis->where('status', 'Belum Diproses')->count() }}</h3>
                                </div>
                                <div class="stat-icon-bg">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block mb-1">Sedang Diproses</small>
                                    <h3 class="mb-0 fw-bold">{{ $aspirasis->where('status', 'Sedang Diproses')->count() }}</h3>
                                </div>
                                <div class="stat-icon-bg">
                                    <i class="bi bi-gear"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm stat-card bg-gradient-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-white-50 d-block mb-1">Selesai</small>
                                    <h3 class="mb-0 fw-bold">{{ $aspirasis->where('status', 'Selesai')->count() }}</h3>
                                </div>
                                <div class="stat-icon-bg">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline History -->
            @if($aspirasis->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-list-ul"></i> Timeline Pengaduan
                    </h6>
                </div>
                <div class="card-body p-4" id="historyContainer">
                    @foreach($aspirasis as $aspirasi)
                    <div class="timeline-item" 
                         data-status="{{ $aspirasi->status }}" 
                         data-bulan="{{ $aspirasi->tanggal_pengaduan->format('m') }}"
                         data-search="{{ strtolower($aspirasi->judul_pengaduan . ' ' . $aspirasi->deskripsi_pengaduan) }}">
                        <div class="timeline-marker 
                            @if($aspirasi->status == 'Belum Diproses') bg-warning
                            @elseif($aspirasi->status == 'Sedang Diproses') bg-info
                            @else bg-success
                            @endif">
                            <i class="bi 
                                @if($aspirasi->status == 'Belum Diproses') bi-hourglass-split
                                @elseif($aspirasi->status == 'Sedang Diproses') bi-gear
                                @else bi-check-circle
                                @endif"></i>
                        </div>
                        
                        <div class="timeline-content">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge 
                                        @if($aspirasi->status == 'Belum Diproses') bg-warning text-dark
                                        @elseif($aspirasi->status == 'Sedang Diproses') bg-info
                                        @else bg-success
                                        @endif mb-2">
                                        {{ $aspirasi->status }}
                                    </span>
                                    <h5 class="mb-1 fw-bold">{{ $aspirasi->judul_pengaduan }}</h5>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3"></i> {{ $aspirasi->tanggal_pengaduan->format('d F Y') }} |
                                        <i class="bi bi-tag"></i> {{ $aspirasi->kategori->nama_kategori }}
                                        @if($aspirasi->lokasi)
                                        | <i class="bi bi-geo-alt"></i> {{ $aspirasi->lokasi }}
                                        @endif
                                    </small>
                                </div>
                                <a href="{{ route('siswa.aspirasi.show', $aspirasi->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </div>
                            
                            <p class="mb-2 text-muted">{{ Str::limit($aspirasi->deskripsi_pengaduan, 150) }}</p>
                            
                            @if($aspirasi->umpanBaliks->count() > 0)
                            <div class="alert alert-info border-0 mt-3 mb-0">
                                <i class="bi bi-chat-left-text-fill"></i> 
                                <strong>Umpan Balik:</strong> Ada {{ $aspirasi->umpanBaliks->count() }} balasan dari admin
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 5rem; color: #ccc;"></i>
                    <h4 class="mt-4 text-muted">Belum Ada Histori</h4>
                    <p class="text-muted">Anda belum pernah membuat pengaduan</p>
                    <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary btn-lg mt-3">
                        <i class="bi bi-plus-circle"></i> Buat Pengaduan Pertama
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);
    }

    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }

    .stat-icon-bg {
        font-size: 2rem;
        opacity: 0.3;
    }

    /* Timeline Styles */
    .timeline-item {
        position: relative;
        padding-left: 50px;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-left: 3px solid #e2e8f0;
    }

    .timeline-item:last-child {
        border-left: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: -17px;
        top: 0;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        50% {
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
    }

    .timeline-content {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        animation: fadeInRight 0.5s ease;
    }

    .timeline-content:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        transform: translateX(5px);
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .hidden-item {
        display: none !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Filter by Status
    document.getElementById('filterStatus').addEventListener('change', function() {
        filterItems();
    });

    // Filter by Bulan
    document.getElementById('filterBulan').addEventListener('change', function() {
        filterItems();
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        filterItems();
    });

    function filterItems() {
        const statusFilter = document.getElementById('filterStatus').value;
        const bulanFilter = document.getElementById('filterBulan').value;
        const searchQuery = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.timeline-item');

        items.forEach(item => {
            const status = item.getAttribute('data-status');
            const bulan = item.getAttribute('data-bulan');
            const searchText = item.getAttribute('data-search');

            let showItem = true;

            // Filter by status
            if (statusFilter && status !== statusFilter) {
                showItem = false;
            }

            // Filter by bulan
            if (bulanFilter && bulan !== bulanFilter) {
                showItem = false;
            }

            // Filter by search
            if (searchQuery && !searchText.includes(searchQuery)) {
                showItem = false;
            }

            if (showItem) {
                item.classList.remove('hidden-item');
            } else {
                item.classList.add('hidden-item');
            }
        });

        // Check if no results
        const visibleItems = document.querySelectorAll('.timeline-item:not(.hidden-item)');
        const container = document.getElementById('historyContainer');
        
        if (visibleItems.length === 0) {
            if (!document.getElementById('no-results')) {
                const noResults = document.createElement('div');
                noResults.id = 'no-results';
                noResults.className = 'text-center py-5';
                noResults.innerHTML = `
                    <i class="bi bi-search" style="font-size: 4rem; color: #ccc;"></i>
                    <h5 class="mt-3 text-muted">Tidak ada hasil ditemukan</h5>
                    <p class="text-muted">Coba ubah filter atau kata kunci pencarian</p>
                `;
                container.appendChild(noResults);
            }
        } else {
            const noResults = document.getElementById('no-results');
            if (noResults) {
                noResults.remove();
            }
        }
    }

    function resetFilter() {
        document.getElementById('filterStatus').value = '';
        document.getElementById('filterBulan').value = '';
        document.getElementById('searchInput').value = '';
        filterItems();
    }
</script>
@endpush
@endsection