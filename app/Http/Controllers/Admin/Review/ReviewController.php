<?php

namespace App\Http\Controllers\Admin\Review;

use App\DTO\ReviewDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\ReviewAddRequest;
use App\Http\Requests\Review\ReviewEditRequest;
use App\Models\Language\Languages;
use App\Models\Reviews\Reviews;
use App\Models\Project\Projects;
use App\Models\User;
use App\Services\CommonService;
use App\Services\ReviewInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    public $defaultLanguage;
    public $validatorCheck;
    public ReviewInterface $reviewInterface;

    public function __construct(ReviewInterface $reviewInterface)
    {

        //Hansi dil defaultdursa onu caqir
        $this->defaultLanguage = cache('language-defaultID') == null ? Languages::where('default', 1)
            ->first()->id : cache('language-defaultID');

        $this->reviewInterface = $reviewInterface;
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
                        SELECT projects.name
                        FROM projects
                        WHERE projects.id = reviews.project_id
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

        $projects = Projects::get();
        return view('admin.review.add', compact(
            'projects'
        ));
    }

    public function store(ReviewAddRequest $request)
    {
        $user = Projects::findOrFail($request->input('project_id'))->employer_id;
        $reviewDTO = new ReviewDTO(
            $request->input('name'),
            $user,
            $request->input('project_id'),
            $request->input('rating'),
            $request->input('review'),
            $request->input('status'),
        );
        Reviews::addReview($reviewDTO);
        return redirect()->route('admin.review.index');


    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $review = Reviews::where('id', (int)$id)
            ->first();


        $projects = Projects::get();


        return view('admin.review.edit', compact(
            'review',
            'projects'
        ));
    }

    public function update(ReviewAddRequest $request)
    {
        $user = Projects::findOrFail($request->input('project_id'))->employer_id;
        $reviewDTO = new ReviewDTO(
            $request->input('name'),
            $user,
            $request->input('project_id'),
            $request->input('rating'),
            $request->input('review'),
            $request->input('status'),
        );

        $review = Reviews::where('id', $request->id)
            ->update([
                'from' => $reviewDTO->from,
                'to' => $reviewDTO->to,
                'project_id' => $reviewDTO->projectId,
                'rating' => $reviewDTO->rating,
                'review' => $reviewDTO->review,
                'status' => $reviewDTO->status,
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

    public function statusAjax(Request $request)
    {
        return $this->reviewInterface->updateStatus(intval($request->id), intval($request->statusActive));
    }
}
