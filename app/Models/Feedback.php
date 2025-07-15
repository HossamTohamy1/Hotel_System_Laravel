<?php

namespace App\Models;

// App\Models\Feedback.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'reservation_id',
        'rating',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
