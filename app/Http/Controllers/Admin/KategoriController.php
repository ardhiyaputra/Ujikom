<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // List kategori
    public function index()
    {
        $kategoris = Kategori::withCount('aspirasis')->get();
        return view('admin.kategori.index', compact('kategoris'));
    }

    // Store kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi' => 'nullable|string'
        ]);

        Kategori::create($request->all());

        return redirect()->route('admin.kategori.index')
                        ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id,
            'deskripsi' => 'nullable|string'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('admin.kategori.index')
                        ->with('success', 'Kategori berhasil diperbarui!');
    }

    // Delete kategori
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        // Cek apakah kategori masih digunakan
        if ($kategori->aspirasis()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                           ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan!');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
                        ->with('success', 'Kategori berhasil dihapus!');
    }
}