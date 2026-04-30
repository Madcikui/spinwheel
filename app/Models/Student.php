<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = [
        'branch_id',
        'umur_id',
        'nama_pelajar',
        'ic_pelajar',
        'nama_ayah',
        'ic_ayah',
        'nama_ibu',
        'ic_ibu',
        'no_telefon',
        'kelas',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function umur(): BelongsTo
    {
        return $this->belongsTo(Umur::class);
    }

    public function spinLog(): HasOne
    {
        return $this->hasOne(SpinLog::class);
    }

    public function hasSpin(): bool
    {
        return $this->spinLog()->exists();
    }
}
