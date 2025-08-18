<?php

namespace App\Http\Controllers\Frontend\Faq;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\SendMailFaq;
use App\Services\FaqRepository;
use App\Services\FaqRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FaqController extends Controller
{
    public function __construct(public FaqRepositoryInterface $faqRepository)
    {
    }

    public function index()
    {
        $faq = $this->faqRepository->all();
       return view('pages.faq', compact('faq'));
    }

    public function contactSendAjax(Request $request)
    {
        $subject = ($request->subject ? $request->subject : "");
        $email = $request->email;
        $data = [
            'subject' => $subject,
            'email' => $email,
        ];

        $responseData = [];

        if (empty($data['email'])) {
            $responseData['email'] = language('frontend.contact.form_error_email');
        } else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $responseData['email'] = language('frontend.contact.form_error_email_invalid');
            }
        }


        if (empty($data['subject'])) {
            $responseData['subject'] = language('frontend.contact.form_error_message');
        }


        if (!empty($data['email']) && !empty($data['subject']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

            $toMail = setting('email');

            Mail::to($toMail)
                ->send(new SendMailFaq($data));

            return response()->json(['success' => true, 'data' => language('frontend.contact.form_success')]);
        } else {
            return response()->json([
                'error' => true,
                'data' => $responseData
            ]);
        }


    }
}
