<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity',
        'sold',
        'sale_start_date',
        'sale_end_date',
        'is_active',
        'seat_label',
        'seat_prefix',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function getIsAvailableAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($this->sale_start_date && $now->lt($this->sale_start_date))
            return false;
        if ($this->sale_end_date && $now->gt($this->sale_end_date))
            return false;
        if ($this->sold >= $this->quantity)
            return false;
        return true;
    }

    public function isAvailable(): bool
    {
        return $this->is_available;
    }

    /**
     * Resolve the seat number to assign for a ticket.
     *
     * @param  int  $seatIndex  0-based index within the current purchase batch
     *                          (used when buying multiple of the same type at once)
     * @return string  The seat number string, e.g. "A3", "VIP-7", "General Admission"
     */
    public function resolveSeatNumber(int $seatIndex = 0): string
    {
        // Auto-numbered mode: seat_prefix + sequential number
        if (!empty($this->seat_prefix)) {
            // $this->sold is the count BEFORE this batch (locked row in transaction)
            $nextNumber = $this->sold + $seatIndex + 1;
            return strtoupper(trim($this->seat_prefix)) . $nextNumber;
        }

        // Static label mode
        if (!empty($this->seat_label)) {
            return $this->seat_label;
        }

        return 'General Admission';
    }
}
