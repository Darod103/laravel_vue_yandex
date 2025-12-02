<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\ReviewsStoreRequest;
use App\Services\ReviewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        ['place' => $place, 'reviews' => $reviews] = ReviewsService::getUserPlaceWithReviews($user);

        return Inertia::render('Reviews/Index', [
            'place'   => $place,
            'reviews' => $reviews,
        ]);
    }

    public function settings(Request $request)
    {
        $place = $request->user()?->place?->only('id', 'status', 'url');

        return inertia('Reviews/ReviewsSettings', [
            'place' => $place,
        ]);
    }

    public function store(ReviewsStoreRequest $request)
    {
        $dto = $request->toDto();
        ReviewsService::parse($dto);
        return redirect()->route('reviews.settings')->with('status', 'pending');

    }

    public function getStatus(Request $request)
    {
        /** @var \App\Models\Place|null $place */
        $place = $request->user()?->place;

        return response()->json([
            'status' => $place?->status,
        ]);
    }
}
