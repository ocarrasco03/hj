<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->request['email'], $this->request['name'])
            ->subject($this->request['subject'])
            ->markdown('emails.forms.contact')
            ->with([
                'subject' => $this->request['subject'],
                'phone' => $this->request['phone'],
                'message' => $this->request['message'],
                'name' => $this->request['name']
            ]);;
    }
}
