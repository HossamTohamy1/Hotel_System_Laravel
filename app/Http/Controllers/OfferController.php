<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Http\Resources\OfferResource;
use App\Services\OfferService;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequests\UpdateOfferRequest;
class OfferController extends Controller
{
    protected OfferService $offerService;

    public function __construct(OfferService $offerService)
    {
        $this->offerService = $offerService;
    }

    public function store(StoreOfferRequest $request)
    {
      return  $this->offerService->createOffer($request);
    }
    public function update($id, UpdateOfferRequest $request)
    {
        return $this->offerService->updateOffer($id, $request);
    }

   
}
