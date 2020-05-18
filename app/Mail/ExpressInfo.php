<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpressInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $expressInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($expressInfo)
    {
        $this->expressInfo = $expressInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->view('view.name');
        return $this->from('sukiworld@sukiworld.cn')->view('emails.express.info')->with([
            'expressInfo' => $this->expressInfo
        ]);
    }
}
