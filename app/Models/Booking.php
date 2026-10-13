<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barber_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    public static array $statusLabels = [
        'pending'   => 'Pending',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    public static array $statusColors = [
        'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
        'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200',
        'completed' => 'bg-green-50 text-green-700 border-green-200',
        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->details->sum(fn($d) => $d->quantity * $d->price);
    }
}
