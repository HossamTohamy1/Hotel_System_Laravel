<?php

namespace App\Http\Controllers;
use App\Services\FeedbackService;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Requests\Feedback\StoreFeedbackRequest;
class FeedbackController extends Controller
{
     protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function store(StoreFeedbackRequest $request)
    {
        return $this->feedbackService->store($request->validated());
    }
}
