<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'code', 'name', 'whatsapp', 'wedding_date', 'event_location',
    'service_id', 'package_id', 'message', 'status',
])]
class Booking extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';

    protected function casts(): array
    {
        return [
            'wedding_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            $booking->code = $booking->code ?: 'BK-'.now()->format('Ymd').'-'.strtoupper(Str::random(4));
            $booking->status = $booking->status ?: self::STATUS_PENDING;
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_CONFIRMED => 'Dikonfirmasi',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => 'Menunggu Konfirmasi',
        };
    }
}
