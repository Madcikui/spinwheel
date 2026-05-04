<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prize extends Model
{
    protected $fillable = [
        'branch_id',
        'umur_id',
        'nama_hadiah',
        'kuantiti',
        'kuantiti_baki',
        'warna',
        'gambar',
        'aktif',
        'boleh_bonus',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'boleh_bonus' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function umur(): BelongsTo
    {
        return $this->belongsTo(Umur::class);
    }
}
