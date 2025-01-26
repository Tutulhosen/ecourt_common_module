<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200;
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
    public function handle()
    {
        $data['title'] = $this->details['email_subject'];
        $data['body'] = $this->details['email_body'];
        $data['email_address_receiver']=$this->details['email_address_receiver'];
        $data["name_of_receiver"]=$this->details['name_of_receiver'];


        Mail::send('mobile_court.Email_templates.miss_report_email_template', $data, function ($message) use ($data) {
            $message->to($data["email_address_receiver"], $data["name_of_receiver"])
                ->subject($data["title"]);
            $message->from('a2iecourt@gmail.com', 'Virtual Court');
        });
    }
}
 