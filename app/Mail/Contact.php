<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $contactInfos;

    /**
     * Create a new message instance.
     *
     * @param array $contactInfos
     */
    public function __construct(Array $contactInfos)
    {
        $this->contactInfos = $contactInfos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@cassrollton.fr')->markdown('emails.markdown.contact');
    }
}
