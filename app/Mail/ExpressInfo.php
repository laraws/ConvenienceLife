<?php

namespace App\Mail;

use App\Models\Express;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ExpressInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $express;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Express $express)
    {
        $this->express = $express;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = 'emails.express.update';
//        $to = User::find($this->expressInfo->user_id)->email;
        $subject = '您的'.$this->express->title.'物流更新';
//        $data = compact('express');
//        $to = User::find($express->user_id)->email;
//        $subject = '您的'.$express->title.'物流更新';
//
//        Mail::send($view, $data, function ($message) use ($to, $subject) {
//            $message->to($to)->subject($subject);
//        });
//        return $this->view($view)->with($data)
////        return $this->view('view.name');
//        return $this->from('sukiworld@sukiworld.cn')->view('emails.express.info')->with([
//            'expressInfo' => $this->expressInfo
//        ]);

        return $this->view($view)->subject($subject);
    }
}
