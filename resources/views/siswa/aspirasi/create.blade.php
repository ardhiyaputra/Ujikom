@extends('layouts.app')

@section('title', 'Buat Pengaduan Baru')

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
            <a class="nav-link active" href="{{ route('siswa.aspirasi.create') }}">
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
                    <h1 class="h3 mb-1 text-gray-800 fw-bold">
                        <i class="bi bi-plus-circle-fill text-primary"></i> Buat Pengaduan Baru
                    </h1>
                    <p class="text-muted mb-0">Sampaikan pengaduan atau masukan terkait sarana dan prasarana sekolah</p>
                </div>
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            
            <!-- Form Card -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-lg">
                        <div class="card-header bg-gradient-primary text-white py-3">
                            <h6 class="m-0 font-weight-bold">
                                <i class="bi bi-file-earmark-text"></i> Form Pengaduan Sarana Sekolah
                            </h6>
                        </div>
                        <div class="card-body p-4">
                                        <form action="{{ route('siswa.aspirasi.store') }}" method="POST" 
                id="formPengaduan" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Info Siswa (Read Only) -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="alert alert-info border-0 shadow-sm">
                                            <h6 class="alert-heading mb-2">
                                                <i class="bi bi-info-circle-fill"></i> Informasi Pelapor
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Nama Siswa</small>
                                                    <strong>{{ session('siswa_nama') }}</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Kelas</small>
                                                    <strong>{{ session('siswa_kelas') }}</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <small class="text-muted d-block">Email</small>
                                                    <strong>{{ session('siswa_email') ?? 'Tidak ada' }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mb-4">

                                <!-- Kategori Pengaduan -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern" for="kategori_id">
                                                <i class="bi bi-tags-fill text-primary"></i> Kategori Pengaduan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select form-control-modern @error('kategori_id') is-invalid @enderror" 
                                                    id="kategori_id" name="kategori_id" required>
                                                <option value="">-- Pilih Kategori --</option>
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
                                                <i class="bi bi-lightbulb"></i> Pilih kategori yang sesuai dengan pengaduan Anda
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Lokasi -->
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern" for="lokasi">
                                                <i class="bi bi-geo-alt-fill text-danger"></i> Lokasi
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-modern @error('lokasi') is-invalid @enderror" 
                                                   id="lokasi" 
                                                   name="lokasi" 
                                                   placeholder="" 
                                                   value="{{ old('lokasi') }}">
                                            @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="bi bi-lightbulb"></i> Sebutkan lokasi spesifik jika ada
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Judul Pengaduan -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern" for="judul_pengaduan">
                                                <i class="bi bi-pencil-square text-success"></i> Judul Pengaduan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control form-control-modern @error('judul_pengaduan') is-invalid @enderror" 
                                                   id="judul_pengaduan" 
                                                   name="judul_pengaduan" 
                                                   placeholder="" 
                                                   value="{{ old('judul_pengaduan') }}"
                                                   required
                                                   maxlength="255">
                                            @error('judul_pengaduan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="bi bi-lightbulb"></i> Buat judul (singkat dan jelas)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Deskripsi Pengaduan -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="form-group-modern">
                                            <label class="form-label-modern" for="deskripsi_pengaduan">
                                                <i class="bi bi-chat-left-text-fill text-warning"></i> Deskripsi Pengaduan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control form-control-modern @error('deskripsi_pengaduan') is-invalid @enderror" 
                                                      id="deskripsi_pengaduan" 
                                                      name="deskripsi_pengaduan" 
                                                      rows="6" 
                                                      placeholder="Jelaskan detail pengaduan Anda secara lengkap."
                                                      required>{{ old('deskripsi_pengaduan') }}</textarea>
                                            @error('deskripsi_pengaduan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="bi bi-lightbulb"></i> Jelaskan masalah dengan detail agar mudah dipahami
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mb-4">

                                <!-- Upload Foto -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="form-group-modern">
            <label class="form-label-modern" for="foto">
                <i class="bi bi-image-fill text-info"></i> Foto Pendukung
            </label>
            <input type="file" 
                   class="form-control form-control-modern @error('foto') is-invalid @enderror" 
                   id="foto" 
                   name="foto"
                   accept="image/jpg,image/jpeg,image/png">
            @error('foto')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                <i class="bi bi-lightbulb"></i> Opsional.
            </small>
            <!-- Preview foto -->
            <div id="fotoPreview" class="mt-2 d-none">
                <img id="previewImg" src="#" alt="Preview" 
                     class="img-thumbnail" style="max-height: 200px;">
            </div>
        </div>
    </div>
</div>

                                <!-- Buttons -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary btn-lg">
                                                <i class="bi bi-x-circle"></i> Batal
                                            </a>
                                            <button type="submit" class="btn btn-primary btn-lg px-5 btn-submit">
                                                <i class="bi bi-send-fill"></i> Kirim Pengaduan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                   

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .form-group-modern {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-label-modern {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control-modern {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .form-control-modern:hover {
        border-color: #667eea;
    }

    textarea.form-control-modern {
        resize: vertical;
        min-height: 150px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(102, 126, 234, 0.4);
    }

    .card {
        animation: fadeInUp 0.6s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-info {
        background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 100%);
        border-left: 4px solid #0ea5e9;
    }

    .form-text {
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Form validation enhancement
    document.getElementById('formPengaduan').addEventListener('submit', function(e) {
        const submitBtn = document.querySelector('.btn-submit');
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengirim...';
        submitBtn.disabled = true;
    });

    // Character counter for textarea
    const textarea = document.getElementById('deskripsi_pengaduan');
    const judulInput = document.getElementById('judul_pengaduan');

    // Auto resize textarea
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Preview foto sebelum upload
document.getElementById('foto').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('fotoPreview').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

</script>
@endpush
@endsection