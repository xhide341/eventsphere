<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Queue\SerializesModels;

class Event extends Model
{
    use HasFactory, SerializesModels;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'venue_id',
        'department_id',
        'speaker_id',
        'image',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'venue_id' => 'integer',
        'department_id' => 'integer',
        'speaker_id' => 'integer',
    ];

    protected $pivotCasts = [
        'registration_date' => 'datetime',
    ];

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'registrations')
            ->withPivot('registration_date')
            ->withTimestamps();
    }

    public function speaker(): BelongsTo
    {
        return $this->belongsTo(Speaker::class);
    }

    public function getUsersCountAttribute(): int
    {
        return $this->users()->count();
    }

    public function isUserRegistered($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function averageRating(): float
    {
        return $this->feedbacks()->avg('rating') ?? 0;
    }


    public function scopeConflictingWith($query, $startDate, $endDate, $startTime, $endTime)
    {
        return $query->where(function ($query) use ($startDate, $endDate, $startTime, $endTime) {
            // Check 1: Is there any event that starts during our timeframe?
            $query->whereBetween('start_date', [$startDate, $endDate])

                // Check 2: Is there any event that ends during our timeframe?
                ->orWhereBetween('end_date', [$startDate, $endDate])

                // Check 3: Is there any event that completely surrounds our timeframe?
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        })
            // AND do the same checks for time
            ->where(function ($query) use ($startTime, $endTime) {
                // Same three checks but for time
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                });
            });
    }
}
