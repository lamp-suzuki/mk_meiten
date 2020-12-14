<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject;
    public $user;
    public $manages;
    public $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $user, $manages, $pass)
    {
        $this->subject = $subject;
        $this->user = $user;
        $this->manages = $manages;
        $this->pass = $pass;
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
        ->text('emails.customer.register')
        ->with([
            'user' => $this->user,
            'manages' => $this->manages,
            'pass' => $this->pass,
        ]);
    }
}
