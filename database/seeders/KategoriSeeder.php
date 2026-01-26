<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Ruang Kelas', 'deskripsi' => 'Pengaduan terkait fasilitas ruang kelas'],
            ['nama_kategori' => 'Toilet', 'deskripsi' => 'Pengaduan terkait kebersihan dan fasilitas toilet'],
            ['nama_kategori' => 'Laboratorium Komputer', 'deskripsi' => 'Pengaduan terkait peralatan dan fasilitas lab'],
            ['nama_kategori' => 'Lapangan Olahraga', 'deskripsi' => 'Pengaduan terkait fasilitas lapangan'],
            ['nama_kategori' => 'Perpustakaan', 'deskripsi' => 'Pengaduan terkait buku dan fasilitas perpustakaan'],
            ['nama_kategori' => 'Kantin', 'deskripsi' => 'Pengaduan terkait kebersihan dan pelayanan kantin'],
            ['nama_kategori' => 'Lainnya', 'deskripsi' => 'Pengaduan lain yang tidak termasuk kategori di atas'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}