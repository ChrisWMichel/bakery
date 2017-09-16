<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class replyToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $order;

    public function __construct($contact, $order)
    {
        $this->contact = $contact;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.replyToCustomer')->subject('Your Bakery, your order.')->to($this->contact['email']);
    }
}
