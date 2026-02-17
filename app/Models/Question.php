<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    protected $fillable = [
        'text',
        'choice_a',
        'choice_b',
        'choice_c',
        'choice_d',
        'correct_choice',
        'time_sec',
        'is_personality',
        'personality_name',
        'personality_description',
        'personality_image',
    ];

    protected $casts = [
        'correct_choice' => 'string',
        'time_sec' => 'integer',
        'is_personality' => 'boolean',
    ];

    public function competitions(): BelongsToMany
    {
        return $this->belongsToMany(Competition::class, 'competition_questions')
                    ->withPivot('sort_order', 'is_personality')
                    ->withTimestamps();
    }
}