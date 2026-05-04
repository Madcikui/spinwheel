<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WinSound extends Model
{
    protected $fillable = [
        'nama',
        'file_path',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
