<?php

namespace App\Console\Commands;

use App\Mail\ExpressInfo;
use App\Models\Express;
use App\Models\User;
use Illuminate\Console\Command;
use App\Services\ExpressService;

class UpdateExpressInfo extends Command
{
    public $expressService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expresses:update';

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
    public function __construct(ExpressService $expressService)
    {
        $this->expressService = $expressService;
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
            if ($express->has_subscribed == 1 && $express->sign_status != 3) {
                $expressInfo = $this->expressService->expressInfo($expresses->tracking_number);
                $this->expressService->expressUpdate($expresses, $expressInfo);
            }

        }
    }
}
