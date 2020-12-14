<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $manages;
    public $users;
    public $orders;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $manages, $users, $orders)
    {
        $this->subject = $subject;
        $this->manages = $manages;
        $this->users = $users;
        $this->orders = $orders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
        ->from('info@take-eats.jp', $this->manages->name)
        ->text('emails.manage.cancel')
        ->with([
            'manages' => $this->manages,
            'users' => $this->users,
            'orders' => $this->orders,
        ]);
    }
}
