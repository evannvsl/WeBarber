<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'Haircut & Styling',
        'Beard & Shave',
        'Hair & Scalp Treatment',
    ];

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'duration_minutes',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
