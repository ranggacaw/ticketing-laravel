<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Traits\LogsActivity;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, LogsActivity;

    protected $fillable = [
        'uuid',
        'user_name',
        'user_email',
        'seat_number',
        'price',
        'type',
        'barcode_data',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->uuid)) {
                $ticket->uuid = (string) Str::uuid();
            }
            if (empty($ticket->barcode_data)) {
                // Initial barcode data could be the UUID or a more complex string
                $ticket->barcode_data = $ticket->uuid;
            }
        });
    }
}
