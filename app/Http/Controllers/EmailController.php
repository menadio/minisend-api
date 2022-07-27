<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Http\Resources\EmailResource;
use Symfony\Component\HttpFoundation\Response;

class EmailController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Handle email sending
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $email = $this->emailService->sendEmail($request);

        if ($email) {
            return $this->successRes('Email sent', null);
        } else {
            return $this->errorRes(
                'Unable to send email',
                null,
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * get sent emails
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = $this->emailService->fetchEmails();

        return $this->successRes(
            'Retrieved emails successfully',
            EmailResource::collection($emails)
        );
    }

    /**
     * get email details
     * 
     * @param \App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        return $this->successRes(
            'Retrieved email details',
            new EmailResource($email->load(['emailBody']))
        );
    }
}
