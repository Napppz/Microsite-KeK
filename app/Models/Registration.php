<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'registration_code',
        'full_name',
        'email',
        'phone_number',
        'position',
        'company_name',
        'organization_type',
        'country',
        'city',
        'participation_category',
        'sectors',
        'sessions',
        'privacy_agreed',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'sectors' => 'array',
        'sessions' => 'array',
        'privacy_agreed' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    public function checkIn(): HasOne
    {
        return $this->hasOne(CheckIn::class);
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    /**
     * Generate unique registration reference code.
     * Format: KEK-{year}-DLG-{random_or_sequence} (e.g. KEK-2025-DLG-8841)
     */
    public static function generateCode(string $year = '2025'): string
    {
        do {
            $randomNum = mt_rand(1000, 9999);
            $code = sprintf('KEK-%s-DLG-%04d', $year, $randomNum);
        } while (static::where('registration_code', $code)->exists());

        return $code;
    }
}
