<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saving(function ($event) {
            if (empty($event->slug)) {
                $slug = Str::slug($event->name);
                $originalSlug = $slug;
                $count = 1;

                while (
                    static::where('slug', $slug)->when($event->exists, function ($query) use ($event) {
                        return $query->where('id', '!=', $event->id);
                    })->exists()
                ) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }

                $event->slug = $slug;
            }
        });
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'start_time',
        'end_time',
        'venue_id',
        'organizer_id',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
