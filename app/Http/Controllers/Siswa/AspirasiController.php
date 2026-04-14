<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    public function index()
    {
        $aspirasis = Aspirasi::where('nama_siswa', session('siswa_nama'))
                            ->where('kelas', session('siswa_kelas'))
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('siswa.dashboard', compact('aspirasis'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('siswa.aspirasi.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'        => 'required|exists:kategoris,id',
            'judul_pengaduan'    => 'required|string|max:255',
            'deskripsi_pengaduan'=> 'required|string',
            'lokasi'             => 'nullable|string|max:255',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_aspirasi', 'public');
        }

        Aspirasi::create([
            'nama_siswa'          => session('siswa_nama'),
            'kelas'               => session('siswa_kelas'),
            'email'               => session('siswa_email'),
            'kategori_id'         => $request->kategori_id,
            'judul_pengaduan'     => $request->judul_pengaduan,
            'deskripsi_pengaduan' => $request->deskripsi_pengaduan,
            'lokasi'              => $request->lokasi,
            'foto'                => $fotoPath,
            'status'              => 'Belum Diproses',
            'tanggal_pengaduan'   => now(),
        ]);

        return redirect()->route('siswa.dashboard')
                        ->with('success', 'Pengaduan berhasil dikirim!');
    }

    public function show($id)
    {
        $aspirasi = Aspirasi::with(['kategori', 'umpanBaliks.admin'])->findOrFail($id);
        
        if ($aspirasi->nama_siswa != session('siswa_nama') || 
            $aspirasi->kelas != session('siswa_kelas')) {
            abort(403, 'Unauthorized');
        }

        return view('siswa.aspirasi.show', compact('aspirasi'));
    }

    public function edit($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
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

    public function update(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
        if ($aspirasi->nama_siswa != session('siswa_nama') || 
            $aspirasi->kelas != session('siswa_kelas')) {
            abort(403, 'Unauthorized');
        }

        if ($aspirasi->status != 'Belum Diproses') {
            return redirect()->route('siswa.dashboard')
                           ->with('error', 'Pengaduan yang sudah diproses tidak dapat diubah!');
        }

        $request->validate([
            'kategori_id'        => 'required|exists:kategoris,id',
            'judul_pengaduan'    => 'required|string|max:255',
            'deskripsi_pengaduan'=> 'required|string',
            'lokasi'             => 'nullable|string|max:255',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = $aspirasi->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($aspirasi->foto) {
                Storage::disk('public')->delete($aspirasi->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_aspirasi', 'public');
        }

        $aspirasi->update([
            'kategori_id'         => $request->kategori_id,
            'judul_pengaduan'     => $request->judul_pengaduan,
            'deskripsi_pengaduan' => $request->deskripsi_pengaduan,
            'lokasi'              => $request->lokasi,
            'foto'                => $fotoPath,
        ]);

        return redirect()->route('siswa.dashboard')
                        ->with('success', 'Pengaduan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
        if ($aspirasi->nama_siswa != session('siswa_nama') || 
            $aspirasi->kelas != session('siswa_kelas')) {
            abort(403, 'Unauthorized');
        }

        if ($aspirasi->status != 'Belum Diproses') {
            return redirect()->route('siswa.dashboard')
                           ->with('error', 'Pengaduan yang sudah diproses tidak dapat dihapus!');
        }

        // Hapus foto jika ada
        if ($aspirasi->foto) {
            Storage::disk('public')->delete($aspirasi->foto);
        }

        $aspirasi->delete();

        return redirect()->route('siswa.dashboard')
                        ->with('success', 'Pengaduan berhasil dihapus!');
    }

    public function history()
    {
        $aspirasis = Aspirasi::where('nama_siswa', session('siswa_nama'))
                            ->where('kelas', session('siswa_kelas'))
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('siswa.aspirasi.history', compact('aspirasis'));
    }
}