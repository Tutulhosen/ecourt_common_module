<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendEmailNotification;
use Illuminate\Support\Facades\Mail; 


class SendEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */


     /* 
     
     $data['title'] = $this->details['email_subject'];
        $data['body'] = $this->details['email_body'];
        $data['email_address_receiver']=$this->details['email_address_receiver'];
        $data["name_of_receiver"]=$this->details['name_of_receiver'];


        Mail::send('mobile_court.Email_templates.miss_report_email_template', $data, function ($message) use ($data) {
            $message->to($data["email_address_receiver"], $data["name_of_receiver"])
                ->subject($data["title"]);
            $message->from('a2iecourt@gmail.com', 'Virtual Court');
        });
     */
    public function handle()
    {
        try {
            $email = new SendEmailNotification($this->details);
            Mail::to($this->details['email_address_receiver'])->send($email);
        } catch (\Exception $e) {
            dd($e);
            // \Log::error('Email sending failed: ' . $e->getMessage());
        };
    }
}
