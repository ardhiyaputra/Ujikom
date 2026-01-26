<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmpanBalik extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspirasi_id',
        'admin_id',
        'isi_umpan_balik',
        'tanggal_umpan_balik',
    ];

    protected $casts = [
        'tanggal_umpan_balik' => 'date',
    ];

    public function aspirasi()
    {
        return $this->belongsTo(Aspirasi::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}