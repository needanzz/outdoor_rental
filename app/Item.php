<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
    protected $fillable = [
        'name',
        'stock',
        'price',
        'description',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRentedCountAttribute()
    {
        // Hitung JUMLAH BARANG (Quantity) yang sedang dipinjam hari ini
        return (int) $this->bookings()
                    ->whereIn('status', ['active', 'pending'])
                    ->whereDate('start_date', '<=', Carbon::today())
                    ->whereDate('end_date', '>=', Carbon::today())
                    ->sum('quantity');
    }
}
