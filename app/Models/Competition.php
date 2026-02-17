<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    protected $fillable = [
        'day_number',
        'title',
        'starts_at',
        'ends_at',
        'is_published',
        'timer_mode',
        'uniform_time_sec',
        'results_published',
        'personality_name',
        'personality_description',
        'personality_image',
        'personality_enabled',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_published' => 'boolean',
        'results_published' => 'boolean',
        'personality_enabled' => 'boolean',
    ];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'competition_questions')
                    ->withPivot('sort_order')
                    ->orderBy('competition_questions.sort_order')
                    ->withTimestamps();
    }

    public function winners(): HasMany
    {
        return $this->hasMany(Winner::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }
}