<?php

namespace App\Jobs;

use App\Mail\EmailTemplate;
use App\Models\Email;
use App\Models\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Mail;

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Email instance
     * 
     * @var \App\Models\Email
     */
    public $email;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Email $email
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email->recipient)
            ->send(new EmailTemplate($this->email));

        // mark email as sent
        $sent = Status::where('name', 'sent')
            ->pluck('id')
            ->first();

        $this->email->update(['status_id' => $sent]);
    }

    /**
     * Handle failure
     * 
     * @return void
     */
    public function failed()
    {
        $failed = Status::where('name', 'failed')
            ->pluck('id')
            ->first();

        $this->email->update(['status_id' => $failed]);
    }
}
