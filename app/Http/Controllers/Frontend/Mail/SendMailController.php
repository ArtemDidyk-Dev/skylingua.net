<?php

namespace App\Http\Controllers\Frontend\Mail;

use App\Http\Controllers\Controller;
use App\Mail\Frontend\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{


    public function send(Request $request)
    {

        //Ashaqidakilar hamisi test uchundur
        //Geleceyde bura girsen fikirleshemeden sile bilersen :))
        $toMail = "testgodnerilenmail@gmail.com";
        $data = "Alindi";

        Mail::to($toMail)
            ->send(new SendMail($data));

    }

}
