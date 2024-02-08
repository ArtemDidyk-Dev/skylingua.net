<?php

namespace App\Http\Controllers\Frontend\Pay;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pay\PayGoRequest;
use App\Models\Chats\ChatMessages;
use App\Models\Chats\Chats;
use App\Models\Notification\Notification;
use App\Models\Pay\Pay;
use App\Models\Project\ProjectHireds;
use App\Models\Project\Projects;
use App\Models\ProjectProposals;
use App\Models\User;
use App\Models\UserCategory\UserCategory;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PayController extends Controller
{
    public $validatorCheck;


    public function go(PayGoRequest $request)
    {

        if ($request->method() == "GET") {
            $employer_id = (int)$request->employer_id;
        } else {
            $employer_id = Auth::id();
        }

        $freelancer_id = (int)$request->freelancer_id;
        $project_id = (int)$request->project_id;

        $price = (isset($request->price) && !empty($request->price) && (float)$request->price > 0 ? (float)$request->price : "");
        $hours = (isset($request->hours) && !empty($request->hours) && (int)$request->hours > 0 ? (int)$request->hours : "");
        $letter = (isset($request->letter) && !empty($request->letter) ? stripinput(strip_tags($request->letter)) : "");


        if (CommonService::userRoleId($employer_id) != 3 && $request->method() == "POST") {
            return redirect()->back();
        }

        $freelancer_filter = [
            'language_id' => $request->languageID
        ];
        $freelancer = User::getUserInfo($freelancer_id, $freelancer_filter);
        if ($freelancer == null || $freelancer->role_id != 4) {
            return redirect()->back();
        }


        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 1,
            'employer_id' => $employer_id
        ];
        $project = Projects::getProject($project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }

        if (!empty($price) && !empty($hours)) {
            $data = [
                'freelancer_id' => $freelancer_id,
                'project_id' => $project_id,
                'price' => $price,
                'hours' => $hours,
                'letter' => $letter,
                'type' => true
            ];
            ProjectProposals::addProposals($data);
        }

        $proposal = ProjectProposals::getProposal($freelancer_id, $project_id);
        if ($proposal == null) {
            return redirect()->back();
        }

        $amount = (float)$proposal->price;


        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);


        //amount check
        if ($amount <= 0) {
            $this->validateCheck('amount', language('frontend.pay.error_amount_minimum'));
        }

        $this->validatorCheck->validate();


        $data = [
            'type' => 1,
            'employer_id' => $employer_id,
            'freelancer_id' => $freelancer_id,
            'project_id' => $project_id,
            'amount' => $amount,
            'currency' => config('pay.currency'),
        ];
        $pay = Pay::addPay($data);

        if (!$pay) {
            return redirect()->back()->with('message', language('frontend.pay.error_not_created_pay'));
        } else {

            $amount = (int)$amount * 100;
            $orderNumber = $pay->id;

            $curl_url = config('pay.base_url') . '/epg/rest/register.do?userName=' . config('pay.username') . '&password=' . config('pay.password') . '&orderNumber=' . $orderNumber . '&amount=' . $amount . '&currency=' . config('pay.currency') . '&returnUrl=' . route('frontend.pay.status') . '&language=' . config('pay.language') . '&sid=' . config('pay.sid');
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $curl_url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    // Set Here Your Requesred Headers
                    'Content-Type: application/json',
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $response_arr = json_decode($response);

//            dd($response_arr);

            if ($err || (isset($response_arr->errorCode) && $response_arr->errorCode > 0)) {
                return redirect()->route('frontend.pay.error')->with('message', language('cURL Error #:') . $err . " " . $response_arr->errorMessage);
            } else {

                if ($response_arr->orderId) {

                    $request->session()->put('guavapay_orderId', $response_arr->orderId);

                    $data = [
                        'orderId' => $response_arr->orderId,
                        'status' => 1,
                    ];
                    $editPay = Pay::editPay($pay->id, $data);
                    if ($editPay == true) {
                        return redirect($response_arr->formUrl);
                    } else {
                        return redirect()->route('frontend.pay.error')->with('message', language('frontend.pay.error_payment_not_edited'));
                    }

                } else {
                    return redirect()->route('frontend.pay.error')->with('message', language('frontend.pay.error_not_order_id'));
                }
            }

        } // if pay

    }


    public function status(Request $request)
    {

//        dd($request);

        $session_guavapay_orderId = "";
        if ($request->session()->exists('guavapay_orderId')) {
            $session_guavapay_orderId = $request->session()->get('guavapay_orderId');
        }

        $orderId = $request->orderId ? $request->orderId : $session_guavapay_orderId;
        if (isset($orderId) && !empty($orderId)) {
            $pay_info = Pay::getByOrderId($orderId);

            if ($pay_info) {


                if (CommonService::userRoleId($pay_info->employer_id) != 3) {
                    return redirect()->route('frontend.pay.error')->with('message', language('User Role Error.'));
                }

                $freelancer_filter = [
                    'language_id' => $request->languageID
                ];
                $freelancer = User::getUserInfo($pay_info->freelancer_id, $freelancer_filter);
                if ($freelancer == null) {
                    return redirect()->route('frontend.pay.error')->with('message', language('Freelancer Error.'));
                }

                $project_filter = [
                    'language_id' => $request->languageID,
                    'status' => 1,
                    'employer_id' => $pay_info->employer_id
                ];
                $project = Projects::getProject($pay_info->project_id, $project_filter);
                if ($project == null) {
                    return redirect()->route('frontend.pay.error')->with('message', "Project Error.");
                }

                $proposal = ProjectProposals::getProposal($pay_info->freelancer_id, $pay_info->project_id);
                if ($proposal == null) {
                    return redirect()->route('frontend.pay.error')->with('message', language('Proposal Error.'));
                }


                $curl_url = config('pay.base_url') . '/epg/rest/getOrderStatus.do?userName=' . config('pay.username') . '&password=' . config('pay.password') . '&orderId=' . $orderId;

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $curl_url,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_HTTPHEADER => array(
                        // Set Here Your Requesred Headers
                        'Content-Type: application/json',
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                $response_arr = json_decode($response);


                if ($err || $response_arr->ErrorCode > 0 || $response_arr->OrderStatus != 2) {

                    $data = [
                        'code' => (int)$response_arr->ErrorCode,
                        'status' => 3,
                    ];
                    $editPay = Pay::editPay($pay_info->id, $data);

                    if ($editPay) {
                        Notification::addNotification($pay_info->employer_id, $err . (!empty($err) ? " " : "") . $response_arr->ErrorMessage, $request->languageID);

                        ProjectProposals::removeProposal($pay_info->freelancer_id, $pay_info->project_id, 1);
                    }


//                    @dd($response_arr);

                    $request->session()->forget('guavapay_orderId');

                    return redirect()->route('frontend.pay.error')->with('message', language('Payment Error #:') . $err . (!empty($err) ? " " : "") . $response_arr->ErrorMessage);
                } else {

                    $data = [
                        'code' => (int)$response_arr->ErrorCode,
                        'status' => 2,
                    ];
                    $editPay = Pay::editPay($pay_info->id, $data);
                    if ($editPay) {
                        $data = [
                            'freelancer_id' => $pay_info->freelancer_id,
                            'project_id' => $pay_info->project_id,
                            'price' => $pay_info->amount,
                            'hours' => $proposal->hours,
                            'letter' => language('I accepted your proposal and made payment. Please start doing work.')
                        ];
                        ProjectHireds::addHireds($data);

                        $employer_text = language('The payment was successful and the task was sent to the freelancer.');
                        $freelancer_text = language('The employer accepted your offer and paid. Immediately, get to work.');

                        Notification::addNotification($pay_info->employer_id, $employer_text, $request->languageID);
                        Notification::addNotification($pay_info->freelancer_id, $freelancer_text, $request->languageID);

                        $user_from = $pay_info->employer_id;
                        $user_to = $pay_info->freelancer_id;
                        $message = language('I chose you and paid. Please get to work immediately.');
                        $file = "";

                        $chat = Chats::getChat($user_from, $user_to);
                        if (!$chat) {
                            Chats::createChat($user_from, $user_to);
                        }
                        ChatMessages::addMessages($user_from, $user_to, $message, $file);
                    }

//                    @dd($response_arr);

//                    $request->session()->forget('guavapay_orderId');


                    return redirect()->route('frontend.pay.success')->with('message', language('Payment made successfully.'));

                }

            }
        }
    }


    public function success(Request $request)
    {

        return view('frontend.pay.success');
    }

    public function error(Request $request)
    {

        return view('frontend.pay.error');
    }

    public function link(Request $request)
    {

        $proposal_id = (int)$request->id;
        $proposal = ProjectProposals::getProposalsById($proposal_id);
        if ($proposal == null) {
            return redirect()->back();
        }

        $project_filter = [
            'language_id' => $request->languageID,
            'status' => 1
        ];
        $project = Projects::getProject($proposal->project_id, $project_filter);
        if ($project == null) {
            return redirect()->back();
        }
//        dd($project);

        $request->session()->put('proposal.id', $proposal->id);
        $request->session()->put('proposal.employer_id', $project->employer_id);
        $request->session()->put('proposal.freelancer_id', $proposal->freelancer_id);
        $request->session()->put('proposal.project_id', $proposal->project_id);
        $request->session()->put('proposal.price', $proposal->price);
        $request->session()->put('proposal.hours', $proposal->hours);
        $request->session()->put('proposal.letter', $proposal->letter);


        return redirect()->route('frontend.pay.go_get', [
            'proposal_id'   => $proposal->id,
            'employer_id'   => $project->employer_id,
            'freelancer_id' => $proposal->freelancer_id,
            'project_id'    => $proposal->project_id,
            'price'         => $proposal->price,
            'hours'         => $proposal->hours,
            '$proposal'     => $proposal->$proposal
        ])->withInput($request->all());


    }


    public function link2(Request $request)
    {


        $method = $request->method();


        dd($method);

    }



public
function validateCheck($inputName, $text)
{
    $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
        $validator->errors()->add($inputName, $text);
    });
}

}
