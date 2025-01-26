<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailNotification extends Mailable
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

     
    public function build()
    {
        return $this->subject($this->details['email_subject'])
                    ->view('mobile_court.Email_templates.miss_report_email_template') // Path to the template
                    ->with([
                        'body' => $this->details['email_body'],
                        'name' => $this->details['name_of_receiver'], // Ensure 'name' is passed instead of 'name_of_receiver'
                    ]);
    }
}
