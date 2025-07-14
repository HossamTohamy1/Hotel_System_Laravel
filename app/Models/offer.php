<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class offer extends Model
{
        protected $fillable = [
        'name',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        
    ];
    public function rooms()
    {
       
        return $this->belongsToMany(Room::class, 'offer_room');
         
    }
    use SoftDeletes;
}
