<?php

// App\Services\FeedbackService.php

namespace App\Services;

use App\Models\Feedback;
use App\Models\Reservation;
use App\Traits\HttpResponses;

class FeedbackService
{
    use HttpResponses;

    public function store(array $data)
    {
        $reservation = Reservation::findOrFail($data['reservation_id']);

        if ($reservation->feedback) {
            return $this->Error(null, 'Feedback already submitted for this reservation.', 409);
        }

        $feedback = Feedback::create($data);

        return $this->Success($feedback, 'Feedback submitted successfully.', 201);
    }
}
