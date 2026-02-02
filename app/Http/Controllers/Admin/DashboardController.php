<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\UmpanBalik;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalAspirasi = Aspirasi::count();
        $belumDiproses = Aspirasi::where('status', 'Belum Diproses')->count();
        $sedangDiproses = Aspirasi::where('status', 'Sedang Diproses')->count();
        $selesai = Aspirasi::where('status', 'Selesai')->count();
        $totalKategori = Kategori::count();

        // Recent Aspirasi
        $recentAspirasi = Aspirasi::with('kategori')
                                  ->orderBy('created_at', 'desc')
                                  ->limit(5)
                                  ->get();

        // Aspirasi per Kategori
        $aspirasiPerKategori = Kategori::withCount('aspirasis')->get();

        return view('admin.dashboard', compact(
            'totalAspirasi',
            'belumDiproses',
            'sedangDiproses',
            'selesai',
            'totalKategori',
            'recentAspirasi',
            'aspirasiPerKategori'
        ));
    }
}