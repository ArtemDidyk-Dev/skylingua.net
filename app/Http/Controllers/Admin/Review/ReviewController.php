<?php

namespace App\Http\Controllers\Admin\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\ReviewAddRequest;
use App\Http\Requests\Review\ReviewEditRequest;
use App\Models\Language\Languages;
use App\Models\Reviews\Reviews;
use App\Models\Project\Projects;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
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


        $reviews = Reviews::select(
                'reviews.*',
                DB::raw("(
                        SELECT users.name
                        FROM users
                        WHERE users.id = reviews.from
                        LIMIT 1
                    ) as reviews_from"),
                DB::raw("(
                        SELECT users.name
                        FROM users
                        WHERE users.id = reviews.to
                        LIMIT 1
                    ) as reviews_to")
            )
            ->groupBy('reviews.id')
            ->orderBy('reviews.id', 'DESC')
            ->paginate(15);

//        dd($reviews);

        return view('admin.review.index', compact('reviews'));
    }

    public function add(Request $request)
    {
        
        $users = User::get();

        return view('admin.review.add', compact(
            'users'
        ));
    }

    public function store(ReviewAddRequest $request)
    {


        $from = (int)$request->from;
        $to = (int)$request->to;
        $rating = (float)$request->rating;
        $review = stripinput($request->review);


        $review = Reviews::addReview([
            'from' => $from,
            'to' => $to,
            'rating' => $rating,
            'review' => $review,
        ]);


        return redirect()->route('admin.review.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $review = Reviews::where('id', (int)$id)
            ->first();


       
        $users = User::get();


        return view('admin.review.edit', compact(
            'review',
            'users'
        ));
    }

    public function update(ReviewEditRequest $request)
    {
        $id = (int)$request->id;
        $from = (int)$request->from;
        $to = (int)$request->to;
        
        $rating = (float)$request->rating;
        $review = stripinput($request->review);

        //CUSTOM VALIDATE START
        $this->validatorCheck = Validator::make(request()->all(), []);

        //Eger gonderilen ID sehfdirse
        $refererError = CommonService::refererError($id);
        if ($refererError) {
            $this->validateCheck('refererID', 'ID Error!');
        }

        $this->validatorCheck->validate();


        $review = Reviews::where('id', $id)
            ->update([
                'from' => $from,
                'to' => $to,
                'rating' => $rating,
                'review' => $review
            ]);


        return redirect()->route('admin.review.index');

    }



    public function sortAjax(Request $request)
    {
        foreach ($request->positions as $item):
            $id = $item[0];
            $sort = $item[1];
            $language = Reviews::where('id', $id)->first();
            if ($language) {
                $language->sort = $sort;
                $language->save();
            }

        endforeach;


        return response()->json(['success' => true]);
    }

    public function deleteAjax(Request $request)
    {
        $id = $request->id;
        Reviews::where('id', $id)
            ->first();

        return response()->json(['success' => true], 200);

    }


    public function delete(Request $request)
    {

        $id = intval($request->id);

        Reviews::where('id', $id)->delete();

        return response()->json(['success' => true], 200);

    }


    public function allDeleteAjax(Request $request)
    {
        $ids = $request->IDs;
        foreach ($ids as $id):
            Reviews::where('id', $id)->delete();
        endforeach;

        return response()->json(['success' => true], 200);

    }


    public function validateCheck($inputName, $text)
    {
        $this->validatorCheck->after(function ($validator) use ($inputName, $text) {
            $validator->errors()->add($inputName, $text);
        });
    }

}
