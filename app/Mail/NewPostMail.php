<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostMail extends Mailable
{
    use Queueable, SerializesModels;

    private $recette;
    private $auteur;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recette, $auteur)
    {
        $this->recette = $recette;
        $this->auteur = $auteur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('emails.markdown.newpostmail')
            ->with ([
                'recette' => $this->recette,
                'auteur' => $this->auteur
            ]);
    }
}
