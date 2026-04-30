<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = [
        'nama_cawangan',
        'slug',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function prizes(): HasMany
    {
        return $this->hasMany(Prize::class);
    }
}
