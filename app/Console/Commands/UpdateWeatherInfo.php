<?php

namespace App\Console\Commands;

use App\Mail\WeatherInfo;
use App\Models\User;
use App\Models\Weather;
use Illuminate\Console\Command;

class UpdateWeatherInfo extends Command
{
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
    public function __construct()
    {
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

            }
        }
    }
}
