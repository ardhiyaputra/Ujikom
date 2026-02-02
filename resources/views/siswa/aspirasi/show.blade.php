@extends('layouts.app')

@section('title', 'Detail Aspirasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        
        {{-- CONTENT --}}
        <div class="col-md-10 offset-md-1 py-4">
            
            <div class="card">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                        Detail Aspirasi
                    </h5>
                </div>

                <div class="card-body">
                    
                    <div class="mb-3">
                        <span class="badge bg-primary">
                            {{ $aspirasi->kategori->nama ?? 'Tanpa Kategori' }}
                        </span>

                        <span class="badge 
                            @if($aspirasi->status == 'Belum Diproses') bg-warning
                            @elseif($aspirasi->status == 'Diproses') bg-info
                            @else bg-success
                            @endif
                        ">
                            {{ $aspirasi->status }}
                        </span>
                    </div>

                    <h4 class="fw-bold mb-3">
                        {{ $aspirasi->judul_pengaduan }}
                    </h4>

                    <p class="text-muted mb-4">
                        {{ $aspirasi->deskripsi_pengaduan }}
                    </p>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-secondary">Nama Siswa</small>
                            <div class="fw-semibold">{{ $aspirasi->nama_siswa }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-secondary">Kelas</small>
                            <div class="fw-semibold">{{ $aspirasi->kelas }}</div>
                        </div>
                    </div>

                    @if($aspirasi->lokasi)
                    <div class="mb-3">
                        <small class="text-secondary">Lokasi</small>
                        <div class="fw-semibold">{{ $aspirasi->lokasi }}</div>
                    </div>
                    @endif

                    <div class="mb-4">
                        <small class="text-secondary">Tanggal Pengaduan</small>
                        <div class="fw-semibold">
                            {{ $aspirasi->tanggal_pengaduan->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <hr>

                    {{-- UMPAN BALIK ADMIN --}}
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-chat-left-text me-1"></i>
                        Umpan Balik Admin
                    </h6>

                    @forelse ($aspirasi->umpanBaliks as $feedback)
                        <div class="border rounded p-3 mb-2 bg-light">
                            <div class="fw-semibold text-primary">
                                {{ $feedback->admin->nama ?? 'Admin' }}
                            </div>
                            <div class="text-muted small mb-1">
                                {{ $feedback->created_at->format('d M Y, H:i') }}
                            </div>
                            <div>
                                {{ $feedback->pesan }}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted fst-italic">
                            Belum ada tanggapan dari admin.
                        </p>
                    @endforelse

                </div>

                <div class="card-footer bg-white text-end">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    @if($aspirasi->status == 'Belum Diproses')
                        <a href="{{ route('siswa.aspirasi.edit', $aspirasi->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
