<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class contact extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content,$email)
    {
        //
	$this->content = $content;
	$this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("From Bschu.net ".date("Y-m-d H:i:s"))->view('contact_mail')->with(["content"=>$this->content,"email"=>$this->email]);
    }

}

