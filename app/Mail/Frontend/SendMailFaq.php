<?php

namespace App\Mail\Frontend;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailFaq extends Mailable
{
    use Queueable, SerializesModels;


    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($address = setting('email'), $name = language('general.site_name'))
            ->subject(language('general.subject_feedback'))
            ->view('frontend.mail.send_faq')
            ->with('data', $this->data);

    }
}
