<?php

namespace App\Console\Commands;

use App\Models\Pay\Pay;
use App\Services\RecurrencePaymentService;

use Illuminate\Console\Command;

class CheckSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Subscription';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private RecurrencePaymentService $recurrencePaymentService
    )
    {
        parent::__construct();
    }


    public function handle()
    {
        $payments = Pay::where(['status' => 2])
            ->whereNotNull('orderId')
            ->whereNotNull('recurrence_id')
            ->whereNotNull('subscribe_id')
            ->whereDate('updated_at', '<=', now()->subMonth())
            ->get();
        if($payments->count() > 0){
            $this->recurrencePaymentService->setPayment($payments)->sendPaymentRequest();
        }
        $this->info('Payment processed');
    }
}
