<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResponseToPatient extends Mailable
{
    use SerializesModels;

    public $patientName;
    public $reply;

    // Reçoit le nom du patient et la réponse de l'admin
    public function __construct($patientName, $reply)
    {
        $this->patientName = $patientName;
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->subject('Your Inquiry has been Resolved')
                    ->view('emails.response_to_patient');
    }
}
