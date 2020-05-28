<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Express;
use App\Mail\ExpressInfo;
use App\Models\User;
use Mail;

class SendExpressNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expresses:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send express notifications';

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
        $expresses = Express::all();
        foreach ($expresses as $express) {
            Mail::to(User::find($express->user_id))->queue(new ExpressInfo($express));
        }
    }
}
