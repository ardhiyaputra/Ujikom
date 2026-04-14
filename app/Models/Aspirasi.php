<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'email',
        'kategori_id',
        'judul_pengaduan',
        'deskripsi_pengaduan',
        'lokasi',
        'foto',
        'status',
        'tanggal_pengaduan',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function umpanBaliks()
    {
        return $this->hasMany(UmpanBalik::class);
    }
}