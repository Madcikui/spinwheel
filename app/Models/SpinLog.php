<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpinLog extends Model
{
    protected $fillable = [
        'student_id',
        'prize_id',
        'status',
        'claimed_at',
        'claimed_by',
        'spun_at',
    ];

    protected $casts = [
        'spun_at' => 'datetime',
        'claimed_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function prize(): BelongsTo
    {
        return $this->belongsTo(Prize::class);
    }

    public function claimedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }
}
