<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasGlobalScope; // Assuming you have a trait for global scopes
class Room extends Model
{
    use HasGlobalScope; 
      protected $fillable = [
        'room_type',
        'room_number',
        'price_per_night',
        'capacity',
        'description',
        'imagePath',
        'available',
    ];
    public function offers()
{
    return $this->belongsToMany(Offer::class, 'offer_room');
}
public function reservations()
{
    return $this->hasMany(Reservation::class);
}


     use SoftDeletes;
}
