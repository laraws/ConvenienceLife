<?php

namespace App\Mail;

use App\Models\Weather;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeatherInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $weather;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Weather $weather)
    {
        $this->weather = $weather;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view = 'emails.weathers.update';
//        $to = User::find($this->expressInfo->user_id)->email;
        $subject = '您的'.$this->weather->title.'天气更新';
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
