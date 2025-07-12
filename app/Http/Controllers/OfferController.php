<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Resources\OfferResource;
use App\Services\OfferService;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    protected OfferService $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function store(StoreOfferRequest $request)
    {
        $data = $request->validated();

        $offer = $this->offerService->createOffer($data);

        return new OfferResource($offer);
    }

   
}
