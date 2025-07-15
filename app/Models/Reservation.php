<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
     use SoftDeletes;
  protected $fillable = [
        'user_id',
        'room_id',
        'offer_id',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'total_amount',
        'status',
    ];
public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function feedback()
{
    return $this->hasOne(Feedback::class);
}
}