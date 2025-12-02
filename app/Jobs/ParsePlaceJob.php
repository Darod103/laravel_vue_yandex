<?php

namespace App\Jobs;

use App\DTO\ParsePlaceDto;
use App\Enum\PlaceStatus;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Throwable;


class ParsePlaceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $userId;
    public string $url;

    /**
     * Create a new job instance.
     */
    public function __construct(ParsePlaceDto $parsePlaceDto)
    {
        $this->userId = $parsePlaceDto->userId;
        $this->url = $parsePlaceDto->url;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::findOrFail($this->userId);


        $place = $user->place ?: new Place(['user_id' => $user->id]);


        if ($place->exists && ($place->url !== $this->url || $place->name !== ($data['org_name'] ?? null))) {
            $place->reviews()->delete();
        }


        $place->fill([
            'user_id' => $user->id,
            'url' => $this->url,
            'status' => PlaceStatus::Processing,
        ]);
        $place->save();

        $res = Http::timeout(60)->retry(2)
            ->post(config('services.parser.base_url') . config('services.parser.endpoint'),
                ["url" => $this->url]);
        if (!$res->successful()) {
            throw new \Exception("Parse error: {$res->status()} - {$res->body()}");
        }
        $data = $res->json()['data'];

        $rating = isset($data['rating'])
            ? (float) str_replace(',', '.', (string) $data['rating'])
            : null;

        $totalReviews = isset($data['total_reviews'])
            ? (int) preg_replace('/\D+/', '', (string) $data['total_reviews'])
            : 0;

        $placeName = $data['org_name'] ?? 'Без названия';
        $placeUrl = $data['url'] ?? $this->url;

        $place->update([
            'user_id' => $user->id,
            'url' => $placeUrl,
            'name' => $placeName,
            'rating' => $rating,
            'total_reviews' => $totalReviews,
            'parsed_at' => now(),
            'status' => PlaceStatus::Done
        ]);

        foreach ($data['reviews'] as $review) {
            Review::updateOrCreate(
                [
                    'place_id' => $place->id,
                    'author' => $review['name'],
                    'date_iso' => $review['date_iso'], // уникальный ключ
                ],
                [
                    'rating' => $review['rating'],
                    'text' => $review['text'] ?? '',
                    'raw_date' => $review['date'],
                ]
            );
        }

    }

    public function failed(Throwable $exception)
    {
        logger()->error('ParsePlaceJob failed', [
            'user_id' => $this->userId,
            'url' => $this->url,
            'error' => $exception->getMessage(),
        ]);
        if ($place = Place::where('url', $this->url)->first()) {
            $place->update([
                'status' => PlaceStatus::Error
            ]);
        }

    }
}
