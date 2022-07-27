<?php

namespace App\Services;

use App\Jobs\ProcessEmail;
use App\Models\Email;
use App\Models\Status;
use App\Models\EmailBody;
use App\Mail\EmailTemplate;
use App\Models\EmailAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EmailService
{
    /**
     * handle send action
     * 
     * @param \App\Models\Email $email
     * @return bool
     */
    public function sendEmail($request)
    {
        // send email
        $this->validate($request);

        return DB::transaction(function () use ($request) {

            // create email
            $email = $this->createEmail($request);

            // store email body
            $this->storeEmailBody($email, $request);

            // store email attachment
            if ($request->attachment) {
                $this->storeAttachment($email, $request);
            }

            // dispatch job
            ProcessEmail::dispatch($email)
                ->delay(now()->addSeconds(5))
                ->afterCommit();

            return $email;
        });
    }

    /**
     * retrieve list of sent emails
     * 
     * @return \App\Models\Email $email
     */
    public function fetchEmails()
    {
        $user = auth()->user();

        $emails = Email::whereBelongsTo($user)
            ->orderBy('id', 'desc')
            ->get();

        return $emails;
    }

    /**
     * handle email storing
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\Email
     */
    public function createEmail($request): Email
    {
        $posted = Status::where('name', 'posted')
            ->pluck('id')->first();

        // create email record
        $email = Email::create([
            'user_id' => $request->user->id,
            'sender' => $request->user->email,
            'recipient' => $request->recipient,
            'subject' => $request->subject,
            'status_id' => $posted
        ]);

        return $email;
    }

    /**
     * store email body
     * 
     * @param \Illuminate\Http\Email $email
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function storeEmailBody($email, $request)
    {
        EmailBody::create([
            'email_id' => $email->id,
            'body'  => $request->body
        ]);
    }

    /**
     * handle email attachments
     * 
     * @param \App\Models\Email $email
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function storeAttachment($email, $request)
    {
        EmailAttachment::create([
            'email_id' => $email->id,
        ]);
    }

    /**
     * validate request
     * 
     * @param \Illuminate\Http\Request $request
     * @return any
     */
    public function validate($request)
    {
        $validation = Validator::make($request->all(), [
            'recipient' => ['required', 'email:rfc,dns'],
            'subject' => ['required', 'string'],
            'body'  => ['required'],
            'attachment' => ['file', 'max:256']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->first()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
