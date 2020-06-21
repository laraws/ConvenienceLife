<?php

namespace App\Console\Commands;

use App\Mail\WeatherInfo;
use App\Models\User;
use App\Models\Weather;
use Illuminate\Console\Command;
use App\Services\WeatherService;

class UpdateWeatherInfo extends Command
{

    public $weatherService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weathers:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $weathers = Weather::all();
        foreach ($weathers as $weather) {
            if ($weather->has_subscribed == 1) {
                $weatherInfo = $this->weatherService->weatherInfo($weather->city, $weather->type, $weather->user_id);
                $this->weatherService->weatherUpdate($weather, $weatherInfo);
            }
        }
    }
}
