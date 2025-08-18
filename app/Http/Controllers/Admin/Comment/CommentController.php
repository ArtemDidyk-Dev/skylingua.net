<?php

namespace App\Http\Controllers\Admin\Comment;

use App\DTO\CommentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\Comment as CommentRequest;
use App\Models\Comment\Comment;
use App\Services\CommentInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public CommentInterface $commentServices;

    public function __construct(CommentInterface $faqInterface)
    {
        $this->commentServices = $faqInterface;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $comments = $this->commentServices->all();

        return view('admin.comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.comment.add');
    }


    public function store(CommentRequest $request)
    {

       $this->commentServices->create_update(new CommentDTO(...$request->validated()));
        return redirect()->route('admin.comment.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment\Comment  $comment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Comment $comment): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {

        return view('admin.comment.edit', compact('comment'));
    }


    public function update(CommentRequest $request, Comment $comment): \Illuminate\Http\RedirectResponse
    {

        $this->commentServices->create_update(new CommentDTO(...$request->validated()), $comment);
        return redirect()->route('admin.comment.index');
    }

    public function delete(Request $request)
    {
       return $this->commentServices->deleteThroughId($request->id);
    }
}
