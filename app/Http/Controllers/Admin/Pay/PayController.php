<?php

namespace App\Http\Controllers\Admin\Pay;

use App\Http\Controllers\Controller;
use App\Models\Language\Languages;
use App\Models\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PayController extends Controller
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


        $pays = Pay::getAll(10);

//        @dd($pays);


        return view('admin.pay.index', compact('pays'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $pay = Pay::with('roles')
            ->where('id', $id)->first();

        if ($pay->roles[0]->id != 1) {


            $data = '';
            $success = '';

            if ($pay) {
                $pay->status = $statusActive;
                $pay->save();

                if ($statusActive == 1) {
                    $data = 1;
                } else {
                    $data = 0;
                }

                $success = true;
            } else {
                $success = false;

            }
        } else {
            $success = false;
            return response()->json(['success' => $success]);
        }

        return response()->json(['success' => $success, 'data' => $data]);
    }


    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        Pay::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        Pay::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

}
