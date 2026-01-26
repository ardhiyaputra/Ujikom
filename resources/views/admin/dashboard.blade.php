@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex">
    <div class="sidebar text-white p-3" style="width: 250px;">
        <div class="text-center mb-4">
            <h5 class="fw-bold">ADMIN PANEL</h5>
            <hr class="bg-white">
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-megaphone"></i> Kelola Aspirasi
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
            <a class="nav-link" href="#">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>
        </nav>
        
        <hr class="bg-white mt-4">
        
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
    
    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Aspirasi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-megaphone fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="text-muted">Selamat datang, {{ Auth::guard('admin')->user()->nama }}!</p>
        </div>
    </div>
</div>
@endsection