<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\ReviewsStoreRequest;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function settings()
    {
        return inertia("Reviews/ReviewsSettings");
    }

    public function store(ReviewsStoreRequest $request)
    {
        $dto = $request->toDto();
        dd($dto);
    }
}
