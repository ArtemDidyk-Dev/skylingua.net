<?php

namespace App\Console\Commands;

use App\Http\Controllers\Frontend\Pay\PayController;
use App\Models\Pay\Pay;
use App\Services\RecurrencePaymentService;
use Illuminate\Console\Command;

class PayCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pay Check';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private PayController $payController,
        private RecurrencePaymentService $recurrencePaymentService,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $payments = Pay::where(['status' => 1])
            ->whereNotNull('orderId')
            ->get();
        $payments->each(function (Pay $payment) {
            $status = $this->payController->checkPaymentStatus($payment);
            $orderStatus = $status['OrderStatus'] ?? 3;
            if($orderStatus == 2) {
                if($payment->subscribe_id !== null) {
                   $subscriptionId = $this->recurrencePaymentService->getSubscriptionId($payment->subscribe_id, $payment->employer_id, 0 );
                   $this->recurrencePaymentService->updatePaymentSubscription($subscriptionId, 1);
                }

                $this->payController->finalizePayment($payment);
            }
            $payment->update(['updated_at' => now()]);
        });
    }
}
