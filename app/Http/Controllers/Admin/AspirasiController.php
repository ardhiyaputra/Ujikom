<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\UmpanBalik;
use Illuminate\Support\Facades\Auth;

class AspirasiController extends Controller
{
    // List semua aspirasi
    public function index(Request $request)
    {
        $query = Aspirasi::with('kategori');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter by tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_pengaduan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_pengaduan', '<=', $request->tanggal_sampai);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('judul_pengaduan', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas', 'like', '%' . $request->search . '%');
            });
        }

        $aspirasis = $query->orderBy('created_at', 'desc')->paginate(15);
        $kategoris = Kategori::all();

        return view('admin.aspirasi.index', compact('aspirasis', 'kategoris'));
    }

    // Detail aspirasi
    public function show($id)
    {
        $aspirasi = Aspirasi::with(['kategori', 'umpanBaliks.admin'])->findOrFail($id);
        return view('admin.aspirasi.show', compact('aspirasi'));
    }

    // Update status aspirasi
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Belum Diproses,Sedang Diproses,Selesai'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status aspirasi berhasil diperbarui!');
    }

    // Store umpan balik
    public function storeUmpanBalik(Request $request, $id)
    {
        $request->validate([
            'isi_umpan_balik' => 'required|string'
        ]);

        UmpanBalik::create([
            'aspirasi_id' => $id,
            'admin_id' => Auth::guard('admin')->id(),
            'isi_umpan_balik' => $request->isi_umpan_balik,
            'tanggal_umpan_balik' => now(),
        ]);

        return redirect()->back()->with('success', 'Umpan balik berhasil dikirim!');
    }

    // Delete aspirasi
    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->delete();

        return redirect()->route('admin.aspirasi.index')
                        ->with('success', 'Aspirasi berhasil dihapus!');
    }
}