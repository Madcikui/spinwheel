<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SpinSound extends Model
{
    protected $fillable = [
        'nama',
        'file_path',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (self $record) {
            if ($record->file_path) {
                Storage::disk('public')->delete($record->file_path);
            }
        });
    }
}
