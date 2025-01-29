<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Requests\Subscriber\SubscriberUser;
use Illuminate\Support\Facades\Auth;


class SubscribersController
{
    public function show() {
        $subscribers = Auth::user()->subscription;
        $user = Auth::user();
        return view('frontend.dashboard.freelancer.subscriber', compact('subscribers', 'user'));
    }

    public function update(SubscriberUser $request)
    {
      $data = $request->validated();
      Auth::user()->subscription->update($data);
      return redirect()->route('frontend.dashboard.subscribers');
    }

    public function store(SubscriberUser $request)
    {
        $data = $request->validated();
        Auth::user()?->subscription()->create($data);
        return redirect()->route('frontend.dashboard.subscribers');
    }
}
