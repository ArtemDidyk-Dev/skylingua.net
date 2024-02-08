<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Models\Country\Country;
use App\Models\Pay\Pay;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Pay\PayoutBankstepOneRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Pay\PayOut;
use App\Models\Notification\Notification;

class WithdrawMoneyController extends Controller
{

    public function __construct()
    {

    }

    public function freelancer(Request $request)
    {   
     
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $totalCredit = 0;
        $moneyHold = 0;


        $pays = Pay::getAllFrelancerPays($user_id);
        if ($pays != null ) {
            foreach ($pays as $pay) {
                if ($pay->status == 6) {
                    $totalCredit = $totalCredit + (float)$pay->amount;
                }

                if ($pay->status == 5) {
                    $moneyHold = $moneyHold + (float)$pay->amount;
                }
            } // foreach
        } // if



        $money = [
            'availableBalance' => $user->balance,
            'totalCredit' => $totalCredit,
            'moneyHold' => $moneyHold
        ];

//        dd($money);


        $filter_countries = [
            'languageID' => $request->languageID,
            'limit' => 9999,
            'sort' => "name",
            'order' => "ASC"
        ];
        $countries = Country::getCountries($filter_countries);
        foreach ($countries as $country) {
            $countriesAll[] = [
                'name' => $country->name,
                'code' => $country->iso
            ];
        }

//        @dd($countries);


        return view('frontend.dashboard.freelancer.withdraw-money', compact(
            'auth_user',
            'user',
            'money',
            'countriesAll'
        ));
    }



    public function bankStep1(PayoutBankstepOneRequest $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $paymentDetails = [];


        $currency = config('pay.currencyLiteral');
        $senderAccount = config('pay.senderAccount');
        $amountOrginal = (float)$request->amount;
        $amountFee = $amountOrginal*config('pay.feeProsent')/100;
        $amount = $amountOrginal+$amountFee;
        $receiverCountry = stripinput($request->receiverCountry);
        $paymentProps = stripinput($request->paymentProps);


        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);




        if (!$senderAccount || !$amount || !$receiverCountry || !$paymentProps) {
            $this->validateCheck('amount', language('frontend.cabinet_pay.all_fields_required'));
        }

        //user check
        if ($user == null) {
            $this->validateCheck('user_id', language('frontend.pay.error_user_not_found'));
        }

        //amount check
        if ((float)$request->amount <= 0) {
            $this->validateCheck('amount', language('frontend.pay.error_amount_minimum'));
        }

        if ($user->balance < $amount) {
            $this->validateCheck('amount', language('frontend.cabinet_pay.balans_low'));
        }

        $this->validatorCheck->validate();



        $data = [
            'type' => 2,
            'senderAccount' => $senderAccount,
            'receiverCountry' => $receiverCountry,
            'amount' => $amount,
            'currency' => $currency,
        ];
        $pay = PayOut::addPay($user_id, $data);



        $curl_url = config('pay.base_url_out') .'/auth';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"clientId\": \"". config('pay.clientId') ."\",
          \"secretKey\": \"". config('pay.secretKey') ."\"
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $response_arr = json_decode($response);


//        @dd($response_arr->accessToken);


        if (isset($response_arr->accessToken) && !empty($response_arr->accessToken)) {
            $curl_url = config('pay.base_url_out') . '/dictionary/payment/fields';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
              \"senderAccount\": \"" . $senderAccount . "\",
              \"receiverCountry\": \"" . $receiverCountry . "\",
              \"amount\": \"" . $amount . "\",
              \"currency\": \"" . $currency . "\"
            }");

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $response_arr->accessToken
            ));

            $response = curl_exec($ch);
            curl_close($ch);


            $response_arr = json_decode($response);

//            @dd($response_arr);

            if (isset($response_arr->mandatoryFields)) {



                if($user->role_id == 3) {
                    $paymentDetails = $response_arr->mandatoryFields->requestForCorporateReceiver;
                } elseif ($user->role_id == 4) {
                    $paymentDetails = $response_arr->mandatoryFields->requestForIndividualReceiver;
                }


                $paymentDetails = array_values_recursive_empty($paymentDetails);




                $paymentDetails->clientOrderId = $pay->id;
//                if(isset($paymentDetails->senderIban)) $paymentDetails->senderIban = $senderAccount;
                if(isset($paymentDetails->amount)) $paymentDetails->amountFee = $amountFee;
                if(isset($paymentDetails->amount)) $paymentDetails->amountOrginal = $amountOrginal;
                if(isset($paymentDetails->amount)) $paymentDetails->amount = $amount;
                if(isset($paymentDetails->receiverCountry)) $paymentDetails->receiverCountry = $receiverCountry;
                if(isset($paymentDetails->paymentDetails)) $paymentDetails->paymentDetails = $paymentProps;
                if(isset($paymentDetails->currency)) $paymentDetails->currency = config('pay.currencyLiteral');
                if($user->role_id == 3) {
                    if(isset($paymentDetails->corporateReceiver->name)) $paymentDetails->corporateReceiver->name = $user->name;
                    if(isset($paymentDetails->corporateReceiver->address->address)) $paymentDetails->corporateReceiver->address->address = $user->address;
                    if(isset($paymentDetails->corporateReceiver->address->country)) $paymentDetails->corporateReceiver->address->country = $receiverCountry;
                } elseif ($user->role_id == 4) {
                    $user_name = explode(" ", $user->name);
                    if(isset($paymentDetails->individualReceiver->firstName)) $paymentDetails->individualReceiver->firstName = (isset($user_name[0]) ? $user_name[0] : $user->name);
                    if(isset($paymentDetails->individualReceiver->firstName)) $paymentDetails->individualReceiver->lastName = (isset($user_name[1]) ? $user_name[1] : "");
                    if(isset($paymentDetails->individualReceiver->address->address)) $paymentDetails->individualReceiver->address->address = $user->address;
                    if(isset($paymentDetails->individualReceiver->address->country)) $paymentDetails->individualReceiver->address->country = $receiverCountry;
                }



                $data = [
                    'commissionAmount' => (float)$response_arr->commissionAmount,
                    'exchangeRate' => stripinput($response_arr->exchangeRate),
                    'billingAmount' => stripinput($response_arr->billingAmount),
                    'billingFee' => stripinput($response_arr->billingFee),
                    'purposeCode' => stripinput($response_arr->purposeCode),
                    'bankCode' => stripinput($response_arr->bankCode),
                    'paymentDetails' => json_encode($paymentDetails),
                ];
                PayOut::editPay($pay->id, $data);

//                @dd($paymentDetails);


                return view('frontend.dashboard.freelancer.pay_out.bank.step1', compact(
                    'auth_user',
                    'user',
                    'paymentDetails'
                ));

            } else {
                return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Payment Error');
            }

        } else {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Payment Error');
        }

    }

    public function bankStep2(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $paymentField = [];
        foreach ($request->paymentField as $paymentField_key => $paymentField_val) {
            $paymentField[stripinput($paymentField_key)] = stripinput($paymentField_val);
        }


//        @dd($paymentField);



        $paymentField['senderIban'] = config('pay.senderAccount');
        $currency = config('pay.currencyLiteral');
        $amount = (float)$paymentField['amount'];
        $id = (int)$paymentField['clientOrderId'];


        $pay = PayOut::getPay($id);


        //user check
        if ($user == null) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', language('frontend.pay.error_user_not_found'));
        }

        if ($user->balance < $amount) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Balance Low');
        }

        //amount check
        if ($amount <= 0) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', language('frontend.pay.error_amount_minimum'));
        }

        if ($pay == null) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Order not found');
        }

        if ($pay->user_id != $user->id) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Order user not found');
        }


        $data = [
            'paymentDetails' => json_encode($paymentField),
        ];
        PayOut::editPay($pay->id, $data);


        $curl_url = config('pay.base_url_out') .'/auth';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"clientId\": \"". config('pay.clientId') ."\",
          \"secretKey\": \"". config('pay.secretKey') ."\"
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $response_access = json_decode($response);


//        @dd($response_arr->accessToken);


        if (isset($response_access->accessToken) && !empty($response_access->accessToken)) {

//            @dd($paymentField);

            $curl_url = config('pay.base_url_out') . '/payments/international';
            $curl_fields = json_encode($paymentField);

//            @dd($curl_fields);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_fields);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $response_access->accessToken
            ));

            $response = curl_exec($ch);
            curl_close($ch);



            $response_international = json_decode($response);

//            @dd($response_international);



            if (isset($response_international->transactionId) && !empty($response_international->transactionId)) {

                $data = [
                    'transactionId' => stripinput($response_international->transactionId),
                ];
                PayOut::editPay($pay->id, $data);

                return view('frontend.dashboard.freelancer.pay_out.bank.step2', compact(
                    'auth_user',
                    'user',
                    'paymentField',
                    'response_international'
                ));

            } else {

                if (isset($response_international->message) && !empty($response_international->message)) {
                    $data = [
                        'paymentError' => stripinput($response_international->message),
                        'status' => 2,
                    ];
                    PayOut::editPay($pay->id, $data);
                }
                return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', (isset($response_international->message) && !empty($response_international->message) ? $response_international->message : 'Payment Error: Payment session expired.'));
            }

        } else {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Payment Error');
        }

    }

    public function bankStep3(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $clientOrderId = (int)$request->clientOrderId;


        $pay = PayOut::getPay($clientOrderId);
        if ($pay == null) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Payment Error');
        }
        $amount = $pay->amount;
        $transactionId = $pay->transactionId;

        //user check
        if (!$user) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', language('frontend.pay.error_user_not_found'));
        }

        if ($user->balance < $amount) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Balance Low');
        }

        //amount check
        if ($amount <= 0) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', language('frontend.pay.error_amount_minimum'));
        }

        if (!$pay) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Order not found');
        }

        if ($pay->user_id != $user->id) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Order user not found');
        }




        $curl_url = config('pay.base_url_out') .'/auth';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"clientId\": \"". config('pay.clientId') ."\",
          \"secretKey\": \"". config('pay.secretKey') ."\"
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $response_access = json_decode($response);


//        @dd($response_arr->accessToken);


        if (isset($response_access->accessToken) && !empty($response_access->accessToken)) {


            $curl_url = config('pay.base_url_out') . '/payments/executor';
            $curl_fields = '["'. $transactionId .'"]';

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_fields);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer ". $response_access->accessToken
            ));

            $response = curl_exec($ch);
            curl_close($ch);



            $response_executor = json_decode($response);

//            @dd($response_executor);

            if (isset($response_executor[0]->paymentId) && !empty($response_executor[0]->paymentId) && $response_executor[0]->error == null) {


                $data = [
                    'paymentId' => (int)$response_executor[0]->paymentId,
                    'status' => 1,
                ];
                PayOut::editPay($pay->id, $data);


                $user_institution = User::where('id', $pay->user_id)->first();
                if ($user_institution) {
                    $pay_chix_amount = (float)$pay->amount + (float)$pay->commissionAmount;
                    if ($user_institution->balance < $pay_chix_amount) {
                        return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', language('frontend.cabinet_pay.balans_low'));
                    }
                    $user_institution->balance = (float)$user_institution->balance - (float)$pay_chix_amount;
                    $user_institution->save();

                    $notification_text = "Transfer -". price_format($pay_chix_amount) .". Available balance: ". price_format($pay_chix_amount) .".";

                    Notification::addNotification($pay->user_id, $notification_text, $request->languageID);

                    $notification_text2 = language('frontend.cabinet_pay.in_progress_notification');

                    Notification::addNotification($pay->user_id, $notification_text2, $request->languageID);
                }


                return redirect()->route('frontend.dashboard.freelancer.pay.bank.stepStatus', $response_executor[0]->paymentId);

            } else {

                $data = [
                    'paymentError' => stripinput($response_executor[0]->error),
                    'status' => 2,
                ];
                PayOut::editPay($pay->id, $data);

                return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', $response_executor[0]->error);
            }
        } else {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Payment Error');
        }

    }



    public function bankStepStatus(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $paymentId = (int)$request->paymentId;


        $pay = PayOut::getByOrderIdAndUserId($paymentId, $user_id);


        //user check
        if ($user == null) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', language('frontend.pay.error_user_not_found'));
        }


        if (!$pay) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Order not found');
        }

        if ($pay->user_id != $user->id) {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Order user not found');
        }


        if ($pay->status > 2) {
            return redirect()->route('frontend.dashboard.freelancer.pay.bank.stepError');
        }

        $curl_url = config('pay.base_url_out') .'/auth';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"clientId\": \"". config('pay.clientId') ."\",
          \"secretKey\": \"". config('pay.secretKey') ."\"
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $response_access = json_decode($response);


//        @dd($response_arr->accessToken);


        if (isset($response_access->accessToken) && !empty($response_access->accessToken)) {

            $curl_url = config('pay.base_url_out') . '/transactions/paymentId/'. $paymentId;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $curl_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer ". $response_access->accessToken
            ));

            $response = curl_exec($ch);
            curl_close($ch);


            $response_payment_status = json_decode($response);


//            @dd($response_payment_status);


            if (isset($response_payment_status->paymentStatus) && !empty($response_payment_status->paymentStatus)) {

                if ($response_payment_status->paymentStatus == "Executed") {
                    $data = [
                        'status' => 4,
                    ];
                    PayOut::editPay($pay->id, $data);
                    return redirect()->route('frontend.dashboard.freelancer.pay.bank.stepSuccess');
                } else {
                    $data = [
                        'status' => 3,
                    ];
                    PayOut::editPay($pay->id, $data);
                    return redirect()->route('frontend.dashboard.freelancer.pay.bank.stepProgress');
                }

            }

        } else {
            return redirect()->route('frontend.dashboard.freelancer.withdraw-money')->with('message', 'Payment Error');
        }



    }

    public function bankStepProgress(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $paymentId = (int)$request->paymentId;


        return view('frontend.dashboard.freelancer.pay_out.bank.progress', compact(
            'auth_user',
            'user',
        ));
    }

    public function bankStepSuccess(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $paymentId = (int)$request->paymentId;



        return view('frontend.dashboard.freelancer.pay_out.bank.success', compact(
            'auth_user',
            'user',
        ));
    }

    public function bankStepError(Request $request)
    {

        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $paymentId = (int)$request->paymentId;


        return view('frontend.dashboard.freelancer.pay_out.bank.error', compact(
            'auth_user',
            'user',
        ));
    }


    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }









    public function freelancerTransactionHistory(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;


        $pays = PayOut::getByUserIdNoStatus($user_id);
        if ($pays) {
            foreach ($pays as $pay_key => $pay) {

                if($pay->status == 4) {
                    $pay->status_text = '<span class="badge bg-success-light">'. language('frontend.common.success') .'</span>';
                } elseif($pay->status == 3) {
                    $pay->status_text = '<span class="badge bg-warning-light">'. language('frontend.common.progress') .'</span>';
                } elseif($pay->status == 2) {
                    $pay->status_text = '<span class="badge bg-danger-light">'. language('frontend.common.error') .'</span>';
                } else {
                    $pay->status_text = '<span class="badge bg-info-light">'. language('frontend.common.created') .'</span>';
                }

                $diffInDays = \Carbon\Carbon::parse($pay->created_at)->diffInDays();
                $showDiff = \Carbon\Carbon::parse($pay->created_at)->diffForHumans();
                if($diffInDays > 0) {
                    $showDiff .= ', ' . \Carbon\Carbon::parse($pay->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
                }

                $pay->date = $showDiff;

                $pays[$pay_key] = $pay;

            } // foreach
        } // if

//        @dd($pays);


        return view('frontend.dashboard.freelancer.transaction-history', compact(
            'auth_user',
            'user',
            'pays'
        ));
    }

    public function freelancerViewInvoice(Request $request)
    {
        $user_id = Auth::id();

        $user_filter = [
            'language_id' => $request->languageID
        ];
        $user = User::getUserInfo($user_id, $user_filter);
        $auth_user = $user;

        $pay_id = (int)$request->id;

        $pay = PayOut::getPayByUserId($pay_id, $user_id);
        if ($pay != null) {
            $diffInDays = \Carbon\Carbon::parse($pay->created_at)->diffInDays();
            $showDiff = \Carbon\Carbon::parse($pay->created_at)->diffForHumans();
            if($diffInDays > 0) {
                $showDiff .= ', ' . \Carbon\Carbon::parse($pay->created_at)->addDays($diffInDays)->diffInHours() . ' Hours';
            }

            $pay->paymentDetails = json_decode($pay->paymentDetails);
            $pay->date = $showDiff;
        }

//        @dd($pay);


        return view('frontend.dashboard.freelancer.view-invoice', compact(
            'auth_user',
            'user',
            'pay'
        ));
    }


}
