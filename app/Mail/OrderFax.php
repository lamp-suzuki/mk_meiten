<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderFax extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $manages;
    public $user;
    public $shop;
    public $data;
    public $service;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $manages, $user, $shop, $service, $data)
    {
        $this->subject = $subject;
        $this->manages = $manages;
        $this->user = $user;
        $this->shop = $shop;
        $this->data = $data;
        $this->service = $service;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
        ->from('info@take-eats.jp', 'TakeEats')
        ->text('emails.manage.thanks')
        ->with([
            'manages' => $this->manages,
            'user' => $this->user,
            'shop' => $this->shop,
            'data' => $this->data,
            'service' => $this->service,
        ]);
    }
}
