<?php

namespace App\Services;

use App\DTO\ParsePlaceDto;
use App\Enum\PlaceStatus;
use App\Jobs\ParsePlaceJob;
use App\Models\Place;
use App\Models\User;


class ReviewsService
{
    public static function parse(ParsePlaceDto $dto)
    {

        $place = Place::firstOrNew(['user_id' => $dto->userId]);
        $place->fill([
            'url' => $dto->url,
            'status' => PlaceStatus::Pending
        ]);
        $place->save();

        ParsePlaceJob::dispatch($dto);

    }


    public static function getUserPlaceWithReviews(User $user): array
    {
        $place = $user->place()
            ->with('reviews')
            ->first();

        $normalizedPlace = $place
            ? $place->only(['id', 'url', 'status', 'name', 'rating', 'total_reviews', 'parsed_at'])
            : null;


        $reviews = $place
            ? $place->reviews()
                ->select('id', 'author', 'rating', 'text', 'raw_date', 'date_iso')
                ->orderByDesc('date_iso')
                ->get()
            : collect();

        return [
            'place' => $normalizedPlace,
            'reviews' => $reviews,
        ];
    }
}
