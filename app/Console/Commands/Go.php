<?php

namespace App\Console\Commands;

use App\Enum\PlaceStatus;
use App\Jobs\ParsePlaceJob;
use App\Models\Place;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;


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
        $res= Http::post(config('services.parser.base_url').config('services.parser.endpoint'), [
            'url'=>'https://yandex.ru/maps/org/madliani_khinkali_i_vino/242132991758/reviews/?filter=alternate_vertical%3ARequestWindow&ll=49.679220%2C58.602888&mode=search&sctx=ZAAAAAgBEAAaKAoSCUmFsYUg10hAEU%2BTGW8rTU1AEhIJJ7wEpz6QjD8RxsIQOX09fz8iBgABAgMEBSgKOABA558NSAFqAnJ1nQHNzMw9oAEAqAEAvQHLgfdIwgEGjv6AgoYHggIr0JzQsNC00LvQuNCw0L3QuCDQpdC40L3QutCw0LvQuCDQuCDQktC40L3QvooCAJICAJoCDGRlc2t0b3AtbWFwc8ICA%2BKCvQ%3D%3D&sll=49.679220%2C58.602888&sspn=0.024580%2C0.009196&tab=reviews&text=%D0%9C%D0%B0%D0%B4%D0%BB%D0%B8%D0%B0%D0%BD%D0%B8%20%D0%A5%D0%B8%D0%BD%D0%BA%D0%B0%D0%BB%D0%B8%20%D0%B8%20%D0%92%D0%B8%D0%BD%D0%BE&z=15.73'
        ]);

        dd($res->json());

    }
}
