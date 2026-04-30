<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BonusCode extends Model
{
    protected $fillable = [
        'code',
        'status',
        'used_by_name',
        'spin_log_id',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    public function spinLog(): BelongsTo
    {
        return $this->belongsTo(SpinLog::class);
    }

    public static function generateCode(): string
    {
        do {
            $code = 'TFE-' . strtoupper(Str::random(6));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public static function generateBulk(int $count): array
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $codes[] = self::create(['code' => self::generateCode()]);
        }
        return $codes;
    }
}
