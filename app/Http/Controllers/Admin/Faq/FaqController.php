<?php

namespace App\Http\Controllers\Admin\Faq;

use App\DTO\FaqDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\Faq\Faq;
use App\Services\FaqInterface;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public FaqInterface $faqServices;

    public function __construct(FaqInterface $faqInterface)
    {
        $this->faqServices = $faqInterface;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq = $this->faqServices->all();
        return view('admin.faq.index', compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.faq.add');
    }


    public function store(FaqRequest $request)
    {
       $this->faqServices->create_update(new FaqDTO(...$request->validated()));
        return redirect()->route('admin.faq.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq\Faq  $faq
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Faq $faq): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.faq.edit', compact('faq'));
    }


    public function update(FaqRequest $request, Faq $faq): \Illuminate\Http\RedirectResponse
    {
        $this->faqServices->create_update(new FaqDTO(...$request->validated()), $faq);
        return redirect()->route('admin.faq.index');
    }

    public function delete(Request $request)
    {
       return $this->faqServices->deleteThroughId($request->id);
    }
}
