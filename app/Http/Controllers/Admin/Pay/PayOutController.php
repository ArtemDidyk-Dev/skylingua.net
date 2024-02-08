<?php

namespace App\Http\Controllers\Admin\Pay;

use App\Http\Controllers\Controller;
use App\Models\Country\Country;
use App\Models\Language\Languages;
use App\Models\Page\Page;
use App\Models\Pay\PayOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PayOutController extends Controller
{

    public $defaultLanguage;

    public function __construct()
    {

        //Hansi dil defaultdursa onu caqir
        $this->defaultLanguage = cache('language-defaultID') == null ? Languages::where('default', 1)
            ->first()->id : cache('language-defaultID');

    }

    public function index(Request $request)
    {

        $payOuts = PayOut::getAll(10);



        foreach ($payOuts as $key => $value):
            $data = [
                'languageID' => $this->defaultLanguage,
                'iso' => $value->receiverCountry,
            ];
            $value->countryName = Country::getCountryByIso($data)['name'];
            $value->amount = number_format($value->amount,2,'.',' ');
            $value->commissionAmount = number_format($value->commissionAmount,2,'.',' ');
            $value->paymentDetails = json_decode($value->paymentDetails);
            $payOuts[$key] = $value;
        endforeach;



        return view('admin.pay.payout.index', compact('payOuts'));
    }


    public function search(Request $request)
    {
        $search = $request->search;



        $payOuts = PayOut::getSearchAll(10,$search);


        foreach ($payOuts as $key => $value):
            $data = [
                'languageID' => $this->defaultLanguage,
                'iso' => $value->receiverCountry,
            ];
            $value->countryName = Country::getCountryByIso($data)['name'];
            $value->amount = number_format($value->amount,2,'.',' ');
            $value->commissionAmount = number_format($value->commissionAmount,2,'.',' ');
            $value->paymentDetails = json_decode($value->paymentDetails);
            $payOuts[$key] = $value;
        endforeach;



        return view('admin.pay.payout.search', compact('payOuts'));
    }



    public function searchID(Request $request)
    {
        $search = $request->user_id;



        $payOuts = PayOut::getSearchID(10,$search);


        foreach ($payOuts as $key => $value):
            $data = [
                'languageID' => $this->defaultLanguage,
                'iso' => $value->receiverCountry,
            ];
            $value->countryName = Country::getCountryByIso($data)['name'];
            $value->amount = number_format($value->amount,2,'.',' ');
            $value->commissionAmount = number_format($value->commissionAmount,2,'.',' ');
            $value->paymentDetails = json_decode($value->paymentDetails);
            $payOuts[$key] = $value;
        endforeach;



        return view('admin.pay.payout.search_id', compact('payOuts'));
    }





    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        PayOut::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        PayOut::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

}
