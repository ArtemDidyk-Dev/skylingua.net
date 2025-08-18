<?php

namespace App\Http\Controllers\Frontend\Cabinet;

use App\Http\Requests\Subscriber\SubscriberUser;
use App\Models\Subscription;
use App\Models\User;
use App\Services\CourseServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SubscribersController
{

    public function __construct(
        private CourseServices $courseServices,
    )
    {
    }

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

    public function unsubscribe(Subscription $subscriber): RedirectResponse
    {
        $subscriber->load('user');
        $teacher = $subscriber->user;
        $user = User::find(Auth::id());
        $user->load('subscriptions');
        if($this->courseServices->isSubscribed($user, $teacher)) {
            $user->subscriptions()->detach($subscriber);
        }
        return redirect()->back();
    }
}
