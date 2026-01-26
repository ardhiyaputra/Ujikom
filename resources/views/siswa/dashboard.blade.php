@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="d-flex">
    <div class="sidebar text-white p-3" style="width: 250px;">
        <div class="text-center mb-4">
            <h5 class="fw-bold">SISWA PANEL</h5>
            <hr class="bg-white">
            <p class="small mb-0">{{ session('siswa_nama') }}</p>
            <small class="text-white-50">{{ session('siswa_kelas') }}</small>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="{{ route('siswa.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-plus-circle"></i> Buat Pengaduan
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-clock-history"></i> Histori Aspirasi
            </a>
        </nav>
        
        <hr class="bg-white mt-4">
        
        <form method="POST" action="{{ route('siswa.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
    
    <div class="flex-grow-1 p-4">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Dashboard Siswa</h1>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, {{ session('siswa_nama') }}!</h5>
                    <p class="card-text">Kelas: {{ session('siswa_kelas') }}</p>
                    <hr>
                    <p>Silakan gunakan menu di samping untuk membuat pengaduan atau melihat histori aspirasi Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection