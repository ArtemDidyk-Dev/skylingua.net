<?php

namespace App\Services;

use App\Http\Controllers\Frontend\Pay\PayController;
use App\Models\Pay\Pay;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


final class RecurrencePaymentService
{
    private Collection $payments;

    public function __construct(
        private PayController $payController
    ) {
    }

    public function sendPaymentRequest(): void
    {
        $ids = $this->payments->pluck('id')->toArray();
        Pay::whereIn('id', $ids)->update(['status' => 1]);
        $this->payments->each(function ($payment) {
            $subscriptionId = $this->getSubscriptionId($payment->subscribe_id, $payment->employer_id, 1);
            if ($subscriptionId)  {
                $this->updatePaymentSubscription($subscriptionId, 0);
                $sendPayment = $this->payController->makeRecurrentPayment($payment);
                $this->setStatusPayment($sendPayment, $payment);
            }
        });
    }

    public function setStatusPayment(array $response, Pay $pay): void
    {
        if ($response['errorCode'] === 0) {
            $pay->update(['status' => 1, 'updated_at' => now(), 'orderId' => $response['orderId']]);
        }
    }

    public function setPayment(Collection $payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    public function getSubscriptionId(int $subscribeId, int $userId, int $status)
    {
        return DB::table('subscription_user')
            ->where('subscription_id', $subscribeId)
            ->where('user_id', $userId)
            ->where('active', $status)
            ->pluck('id')
            ->first();
    }

    public function updatePaymentSubscription(int $subscribeId, int $status): void
    {
        DB::table('subscription_user')
            ->where('id', $subscribeId)
            ->update(['active' => $status]);
    }

}


