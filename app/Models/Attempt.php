<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attempt extends Model
{
    protected $fillable = [
        'user_id', 'competition_id', 'status', 'started_at', 'submitted_at',
        'score', 'correct_count', 'wrong_count', 'blank_count',
        'ip_address', 'user_agent', 'current_index', 'current_question_started_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'current_question_started_at' => 'datetime',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع المسابقة (اليوم)
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * العلاقة مع إجابات المحاولة
     */
    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}