<?php

namespace App\Http\Controllers\Admin\Subscriber;

use App\Http\Requests\Subscriber\SubscriberAdmin;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;


class SubscriberController
{
    public function index()
    {
        $subscribers = Subscription::with('user')->orderBy('id', 'desc')->get();
        return view('admin.subscriber.index', compact('subscribers'));
    }

    public function create()
    {
        $users = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('id', 4);
            })->where(['status' => 1, 'approve' => 1])->doesntHave('subscription')->get();
        return view('admin.subscriber.add', compact('users'));
    }

    public function store(SubscriberAdmin $request)
    {
        $data = $request->validated();
        Subscription::create($data);
        return redirect()->route('admin.subscriber.index')->with('success', 'Subscriber added successfully');
    }

    public function edit(Subscription $subscriber)
    {
        $subscriber->load('user');
        $users = User::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('id', 4);
            })->where(['status' => 1, 'approve' => 1])->doesntHave('subscription')->get();
        $users->prepend($subscriber->user);
        return view('admin.subscriber.edit', compact('users', 'subscriber'));
    }

    public function update(SubscriberAdmin $request, Subscription $subscriber)
    {
        $data = $request->validated();
        $subscriber->update($data);
        return redirect()->route('admin.subscriber.index')->with('success', 'Subscriber updated successfully');
    }

    public function delete(Request $request) {
       Subscription::find($request->id)->delete();
        return response()->json(['success' => true], 200);
    }


}
