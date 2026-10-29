<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'year',
        'edition',
        'dates_label',
        'venue_name',
        'venue_address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(CheckIn::class);
    }

    /**
     * Get or create current active event based on configuration.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['slug' => 'kek-business-forum-' . config('event.year', '2025')],
            [
                'name' => config('event.name', 'KEK Business Forum'),
                'year' => (string) config('event.year', '2025'),
                'edition' => config('event.edition', 'Edisi Konferensi 2025'),
                'dates_label' => config('event.dates', '[Tanggal Pelaksanaan Acara]'),
                'venue_name' => config('event.venue_name', '[Nama Gedung & Lokasi Acara]'),
                'venue_address' => config('event.venue_address', 'Jl. Gatot Subroto No. 1, Senayan, Jakarta Pusat 10270'),
                'is_active' => true,
            ]
        );
    }
}
