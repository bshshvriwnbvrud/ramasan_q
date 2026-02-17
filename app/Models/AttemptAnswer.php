<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptAnswer extends Model
{
    protected $fillable = [
        'attempt_id',
        'question_id',
        'question_index',
        'selected_choice',
        'is_correct',
        'was_late',
        'answered_at'
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'is_correct' => 'boolean',
        'was_late' => 'boolean',
    ];

    /**
     * العلاقة مع المحاولة
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }

    /**
     * العلاقة مع السؤال
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}