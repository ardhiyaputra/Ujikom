<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;
use PDF; // Nanti kita install dompdf

class LaporanController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.laporan.index', compact('kategoris'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tanggal_dari' => 'required|date',
            'tanggal_sampai' => 'required|date|after_or_equal:tanggal_dari',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'status' => 'nullable|in:Belum Diproses,Sedang Diproses,Selesai'
        ]);

        $query = Aspirasi::with('kategori')
                        ->whereDate('tanggal_pengaduan', '>=', $request->tanggal_dari)
                        ->whereDate('tanggal_pengaduan', '<=', $request->tanggal_sampai);

        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $aspirasis = $query->orderBy('tanggal_pengaduan', 'desc')->get();

        $data = [
            'aspirasis' => $aspirasis,
            'tanggal_dari' => $request->tanggal_dari,
            'tanggal_sampai' => $request->tanggal_sampai,
            'kategori' => $request->kategori_id ? Kategori::find($request->kategori_id)->nama_kategori : 'Semua',
            'status' => $request->status ?? 'Semua'
        ];

        return view('admin.laporan.preview', $data);
    }
}