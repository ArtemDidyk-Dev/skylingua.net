<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\PortfolioAddAdminRequest;
use App\Http\Requests\Portfolio\PortfolioAddRequest;
use App\Http\Requests\Portfolio\PortfolioEditAdminRequest;
use App\Http\Requests\Portfolio\PortfolioEditRequest;
use App\Models\Language\Languages;
use App\Models\Portfolio\Portfolio;
use App\Models\Portfolio\PortfolioTranslation;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;

class PortfolioController extends Controller
{
    public $defaultLanguage;
    public $validatorCheck;


    public function __construct()
    {

        //Hansi dil defaultdursa onu caqir
        $this->defaultLanguage = cache('language-defaultID') == null ? Languages::where('default', 1)
            ->first()->id : cache('language-defaultID');

    }

    public function index(Request $request)
    {


        $portfolios = Portfolio::select(
            'portfolio.*',
            'users.name as user_name',
        )
            ->leftJoin('users', 'portfolio.user_id', '=', 'users.id')
            ->orderBy('portfolio.id', 'DESC')
            ->paginate(10);


        return view('admin.portfolio.index', compact('portfolios'));
    }

    public function add(Request $request)
    {

        $users = User::where(['status' => 1, 'approve' => 1])->get();

        return view('admin.portfolio.add',
            [
                'users' => $users->all()
            ]
        );
    }

    public function store(PortfolioAddAdminRequest $request)
    {

        $user_id = $request->user;

        $data = [
            'title' => stripinput($request->title),
            'link' => stripinput($request->link)
        ];

        $portfolio = Portfolio::add($user_id, $data);
        $image = (is_null($request->image) ? "" : $this->saveImage($request->file('image'), $user_id));
        $portfolio->image = $image;
        $portfolio->save();
        return redirect()->route('admin.portfolio.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $portfolio = Portfolio::where('id', $id)->first();


        return view('admin.portfolio.edit', compact('portfolio'));
    }

    public function update(PortfolioEditAdminRequest $request)
    {

        $id = $request->id;
        $title = $request->title;
        $approve = $request->approve;
        $image = $request->image;

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        //Eger gonderilen ID sehfdirse
        $refererError = CommonService::refererError($id);
        if ($refererError) {
            $this->validateCheck('refererID', 'Səhf ID istifadə etdiniz!');
        }


        if (!in_array($approve, [0, 1])) {
            $this->validateCheck('status', 'Approve error.');
        }

        $this->validatorCheck->validate();


        $portfolio = Portfolio::where('id', $id)->first();
        $portfolio->title = $title;
        $portfolio->approve = $approve;
        $portfolio->image = str_replace(env('APP_URL'), '', $image);
        $portfolio->updated_at = date('Y-m-d H:i:s');
        $portfolio->save();


        return redirect()->route('admin.portfolio.index');


    }

    public function search(Request $request)
    {
        $search = $request->search;

        $portfolios = Portfolio::select(
            'portfolio.*',
            'users.name as user_name',
        )
            ->leftJoin('users', 'portfolio.user_id', '=', 'users.id')
            ->where('portfolio.title', 'like', '%' . $search . '%')
            ->orderBy('portfolio.id', 'DESC')
            ->paginate(10);


        return view('admin.portfolio.search', compact('portfolios'));
    }


    public function statusAjax(Request $request)
    {
        $id = intval($request->id);
        $statusActive = intval($request->statusActive);

        $portfolio = Portfolio::where('id', $id)->first();
        $data = '';
        $success = '';

        if ($portfolio) {
            $portfolio->approve = $statusActive;
            $portfolio->save();

            if ($statusActive == 1) {
                $data = 1;
            } else {
                $data = 0;
            }

            $success = true;
        } else {
            $success = false;

        }


        return response()->json(['success' => $success, 'data' => $data]);
    }

    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        Portfolio::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }

    public function delete(Request $request)
    {

        $id = intval($request->id);

        Portfolio::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }

    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }

    public function saveImage($image_64, $user_id)
    {
        $destinationpath = "public/portfolio";
        $imageName = $user_id . '-' . Str::random(20) . '.jpg';
        Storage::put($destinationpath . '/' . $imageName, file_get_contents($image_64));
        return  $imageName;
    }
}
