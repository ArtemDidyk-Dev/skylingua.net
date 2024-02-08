<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\PortfolioAddRequest;
use App\Http\Requests\Portfolio\PortfolioDeleteRequest;
use App\Http\Requests\Portfolio\PortfolioEditRequest;
use App\Models\Portfolio\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public $validatorCheck;

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


//        $portfolios = Portfolio::getByUserId($user_id, 9);

        $portfolios = Portfolio::getByUserIdOwner($user_id, 9);

         if (isset($request->page) && $request->page > 1) {
             $request->session()->put('curentPage', (int)$request->page);
         } else {
             $request->session()->forget('curentPage');
         }


        return view('frontend.dashboard.freelancer.portfolio', compact(
            'auth_user',
            'user',
            'portfolios'
        ));
    }

    public function addStore(PortfolioAddRequest $request)
    {

        if ($request->session()->exists('curentPage')) {
            $curentPage = $request->session()->get('curentPage');
        } else {
            $curentPage = false;
        }

        $user_id = Auth::id();

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        //foto format check
        $image_64 = $request->image_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('image', language('frontend.portfolio.error_image'));
            }

        }

        $this->validatorCheck->validate();

        $data = [
            'title' => stripinput($request->title),
            'link' => stripinput($request->link)
        ];

        $portfolio = Portfolio::add($user_id, $data);


        //image
        if ($request->hasFile('image') || !empty($request->image_upload)) {

            if (!empty($portfolio->image)) {
                Storage::delete('public/portfolio/' . $portfolio->image);
            }


            $image_64 = $request->image_upload; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);


            $destinationpath = "public/portfolio";
            $imageName = $user_id . '-' . Str::random(20) . '.jpg';
            Storage::put($destinationpath . '/' . $imageName, base64_decode($image));


            //foto yuklendikden sonra compres et
            $destinationPathStorage = "storage/portfolio";
            compressImgFile($destinationPathStorage . '/' . $imageName, $destinationPathStorage . '/' . $imageName, 80);


            //bazaya yaz
            $portfolio->image = $imageName;
        }

        //Foto Legv olunmushsa
        if($request->not_photo == '1') {

            if (!empty($portfolio->image)) {
                Storage::delete('public/portfolio/' . $portfolio->image);
            }
            $portfolio->image = '';

        }


        $portfolio->save();




        return redirect()->route('frontend.dashboard.freelancer.portfolio')->with('message', language('frontend.portfolio.success_added'));


    }

    public function editStore(PortfolioEditRequest $request)
    {
        if ($request->session()->exists('curentPage')) {
            $curentPage = $request->session()->get('curentPage');
        } else {
            $curentPage = false;
        }

        $user_id = Auth::id();

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        //foto format check
        $image_64 = $request->image_upload; //your base64 encoded data
        if (!empty($image_64)) {
            if (!is_base64($image_64)) {
                $this->validateCheck('image', language('frontend.portfolio.error_image'));
            }

        }

        $this->validatorCheck->validate();


        $portfolio = Portfolio::where('user_id', $user_id)
            ->where('id', (int)$request->id)
            ->first();
        if ($portfolio == null) {
            return redirect()->back();
        }

        if (isset($request->title) && !empty($request->title)) {
            $portfolio->title = stripinput($request->title);
        }
        if (isset($request->link) && !empty($request->link)) {
            $portfolio->link = stripinput($request->link);
        }

        //image
        if ($request->hasFile('image') || !empty($request->image_upload)) {

            if (!empty($portfolio->image)) {
                Storage::delete('public/portfolio/' . $portfolio->image);
            }


            $image_64 = $request->image_upload; //your base64 encoded data
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);


            $destinationpath = "public/portfolio";
            $imageName = $user_id . '-' . Str::random(20) . '.jpg';
            Storage::put($destinationpath . '/' . $imageName, base64_decode($image));


            //foto yuklendikden sonra compres et
            $destinationPathStorage = "storage/portfolio";
            compressImgFile($destinationPathStorage . '/' . $imageName, $destinationPathStorage . '/' . $imageName, 80);


            //bazaya yaz
            $portfolio->image = $imageName;
        }

        //Foto Legv olunmushsa
        if($request->not_photo == '1') {

            if (!empty($portfolio->image)) {
                Storage::delete('public/portfolio/' . $portfolio->image);
            }
            $portfolio->image = '';

        }


        $portfolio->save();


        return redirect()->route('frontend.dashboard.freelancer.portfolio', ($curentPage!=false ? 'page='. $curentPage : ''))->with('message', language('frontend.portfolio.success_edited'));


    }

    public function deleteStore(PortfolioDeleteRequest $request)
    {
        if ($request->session()->exists('curentPage')) {
            $curentPage = $request->session()->get('curentPage');
        } else {
            $curentPage = false;
        }

        $user_id = Auth::id();

        $portfolio = Portfolio::where('user_id', $user_id)
            ->where('id', (int)$request->id)
            ->first();
        if ($portfolio == null) {
            return redirect()->back();
        }

        if (!empty($portfolio->image)) {
            Storage::delete('public/portfolio/' . $portfolio->image);
        }


        $portfolio->delete();


        return redirect()->route('frontend.dashboard.freelancer.portfolio', ($curentPage!=false ? 'page='. $curentPage : ''))->with('message', language('frontend.portfolio.success_deleted'));

    }


    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }


}
