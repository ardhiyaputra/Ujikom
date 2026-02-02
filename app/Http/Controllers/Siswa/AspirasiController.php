<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;

class AspirasiController extends Controller
{
    // Halaman Dashboard - List Aspirasi Siswa
    public function index()
    {
        $aspirasis = Aspirasi::where('nama_siswa', session('siswa_nama'))
                            ->where('kelas', session('siswa_kelas'))
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('siswa.dashboard', compact('aspirasis'));
    }

    // Halaman Form Buat Pengaduan Baru
    public function create()
    {
        $kategoris = Kategori::all();
        return view('siswa.aspirasi.create', compact('kategoris'));
    }

    // Proses Simpan Pengaduan Baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi_pengaduan' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
        ]);

        Aspirasi::create([
            'nama_siswa' => session('siswa_nama'),
            'kelas' => session('siswa_kelas'),
            'email' => session('siswa_email'),
            'kategori_id' => $request->kategori_id,
            'judul_pengaduan' => $request->judul_pengaduan,
            'deskripsi_pengaduan' => $request->deskripsi_pengaduan,
            'lokasi' => $request->lokasi,
            'status' => 'Belum Diproses',
            'tanggal_pengaduan' => now(),
        ]);

        return redirect()->route('siswa.dashboard')
                        ->with('success', 'Pengaduan berhasil dikirim!');
    }

    // Halaman Detail Pengaduan
    public function show($id)
    {
        $aspirasi = Aspirasi::with(['kategori', 'umpanBaliks.admin'])->findOrFail($id);
        
        // Pastikan siswa hanya bisa lihat pengaduan mereka sendiri
        if ($aspirasi->nama_siswa != session('siswa_nama') || 
            $aspirasi->kelas != session('siswa_kelas')) {
            abort(403, 'Unauthorized');
        }

        return view('siswa.aspirasi.show', compact('aspirasi'));
    }

    // Halaman Edit Pengaduan (hanya jika belum diproses)
    public function edit($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
        // Validasi: hanya bisa edit pengaduan sendiri dan belum diproses
        if ($aspirasi->nama_siswa != session('siswa_nama') || 
            $aspirasi->kelas != session('siswa_kelas')) {
            abort(403, 'Unauthorized');
        }

        if ($aspirasi->status != 'Belum Diproses') {
            return redirect()->route('siswa.dashboard')
                           ->with('error', 'Pengaduan yang sudah diproses tidak dapat diubah!');
        }

        $kategoris = Kategori::all();
        return view('siswa.aspirasi.edit', compact('aspirasi', 'kategoris'));
    }

    // Proses Update Pengaduan
    public function update(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
        // Validasi
        if ($aspirasi->nama_siswa != session('siswa_nama') || 
            $aspirasi->kelas != session('siswa_kelas')) {
            abort(403, 'Unauthorized');
        }

        if ($aspirasi->status != 'Belum Diproses') {
            return redirect()->route('siswa.dashboard')
                           ->with('error', 'Pengaduan yang sudah diproses tidak dapat diubah!');
        }

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi_pengaduan' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $aspirasi->update([
            'kategori_id' => $request->kategori_id,
            'judul_pengaduan' => $request->judul_pengaduan,
            'deskripsi_pengaduan' => $request->deskripsi_pengaduan,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('siswa.dashboard')
                        ->with('success', 'Pengaduan berhasil diperbarui!');
    }

    // Proses Hapus Pengaduan (hanya jika belum diproses)
    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
        // Validasi
        if ($aspirasi->nama_siswa != session('siswa_nama') || 
            $aspirasi->kelas != session('siswa_kelas')) {
            abort(403, 'Unauthorized');
        }

        if ($aspirasi->status != 'Belum Diproses') {
            return redirect()->route('siswa.dashboard')
                           ->with('error', 'Pengaduan yang sudah diproses tidak dapat dihapus!');
        }

        $aspirasi->delete();

        return redirect()->route('siswa.dashboard')
                        ->with('success', 'Pengaduan berhasil dihapus!');
    }

    // Halaman Histori Aspirasi
    public function history()
    {
        $aspirasis = Aspirasi::where('nama_siswa', session('siswa_nama'))
                            ->where('kelas', session('siswa_kelas'))
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('siswa.aspirasi.history', compact('aspirasis'));
    }
}