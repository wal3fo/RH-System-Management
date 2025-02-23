<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class RequestClient extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
   
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
   
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $this->subject($this->details->Title);

        $this->from(env('MAIL_FROM_ADDRESS'), $this->details->Name);
        
        $this->with([
            'ClientName' => $this->details->ClientName,
            'TypeName' => $this->details->TypeName,
            'TypeVacancy' => $this->details->TypeVacancy,
            'NumDays' => $this->details->NumDays,
            'TimeOf' => $this->details->TimeOf,
            'Status' => $this->details->Status,
            'StartDate' => $this->details->StartDate,
            'EndDate' => $this->details->EndDate,
            ]);

        $this->view("mails.request");

        return $this;
    }
}
