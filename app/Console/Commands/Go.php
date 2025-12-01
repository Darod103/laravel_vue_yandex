<?php

namespace App\Console\Commands;

use App\Enum\PlaceStatus;
use App\Jobs\ParsePlaceJob;
use App\Models\Place;
use Illuminate\Console\Command;


class Go extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go';

    /**
     * The console command description.
     *
     * @var string
     */


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $places = Place::create([
            'url'=>'https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/',
            'status'=>PlaceStatus::Pending
        ]);
        ParsePlaceJob::dispatch(1,$places->url);
    }
}
