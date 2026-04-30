<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Umur extends Model
{
    protected $fillable = [
        'nama',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function prizes(): HasMany
    {
        return $this->hasMany(Prize::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
