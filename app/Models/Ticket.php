<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'registration_id',
        'ticket_number',
        'qr_token',
        'encrypted_token',
        'status',
        'issued_at',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    /**
     * Hide sensitive token material from serialization.
     */
    protected $hidden = [
        'encrypted_token',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    /**
     * Safely recover the raw opaque token using Laravel's encryption facility.
     */
    public function getRawToken(): ?string
    {
        if (empty($this->encrypted_token)) {
            return null;
        }

        try {
            return Crypt::decryptString($this->encrypted_token);
        } catch (\Throwable) {
            return null;
        }
    }
}
