<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function arguments(): HasMany
    {
        return $this->hasMany(Argument::class);
    }

    public function argumentsWithBody(): HasMany
    {
        return $this->hasMany(Argument::class)
            ->whereNotNull('body')
            ->orderByDesc('vote_count');
    }

    public function argumentsWithBodyAndYes(): HasMany
    {
        return $this->hasMany(Argument::class)
            ->whereNotNull('body')
            ->where('type', VoteType::YES)
            ->orderByDesc('vote_count');
    }

    public function argumentsWithBodyAndNo(): HasMany
    {
        return $this->hasMany(Argument::class)
            ->whereNotNull('body')
            ->where('type', VoteType::NO)
            ->orderByDesc('vote_count');
    }

    public function argumentsWithYes(): HasMany
    {
        return $this->hasMany(Argument::class)
            ->where('type', VoteType::YES)
            ->orderByDesc('vote_count');
    }

    public function argumentsWithNo(): HasMany
    {
        return $this->hasMany(Argument::class)
            ->where('type', VoteType::NO)
            ->orderByDesc('vote_count');
    }

    public function total(): Attribute
    {
        return new Attribute(
            get: fn () => $this->count_yes + $this->count_no,
        );
    }

    public function percentageYes(): Attribute
    {
        return Attribute::make(
            get: fn () => round(($this->count_yes / $this->total) * 100),
        );
    }

    public function percentageNo(): Attribute
    {
        return Attribute::make(
            get: fn () => round(($this->count_no / $this->total) * 100),
        );
    }

    public function updateCounts(): void
    {
        $this->update([
            'count_yes' => $this->argumentsWithYes()->count(),
            'count_no' => $this->argumentsWithNo()->count(),
        ]);
    }
}
