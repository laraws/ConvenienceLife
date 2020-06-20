<?php

namespace App\Console\Commands;

use App\Mail\WeatherInfo;
use App\Models\Weather;
use Illuminate\Console\Command;
use Mail;
use App\Models\User;

class SendWeatherNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weathers:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weathers notifications';

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
                Mail::to(User::find($weather->user_id))->queue(new WeatherInfo($weather));
            }
        }
    }
}
