<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'username',
        'password',
        'email',
    ];

    protected $hidden = [
        'password',
    ];

    public function umpanBaliks()
    {
        return $this->hasMany(UmpanBalik::class);
    }
}