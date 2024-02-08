<?php

namespace App\Models\Pay;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayOut extends Model
{
    use HasFactory;

    protected $table = 'pay_out';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function addPay($user_id, $data = [])
    {

        $pay = PayOut::create([
            'user_id' => (int)$user_id,
            'type' => (int)$data['type'],
            'senderAccount' => stripinput($data['senderAccount']),
            'receiverCountry' => stripinput($data['receiverCountry']),
            'amount' => (float)$data['amount'],
            'currency' => stripinput($data['currency']),
            'status' => 0
        ]);

        return $pay;

    }

    public static function editPay($pay_id, $data = [])
    {

        $pay = PayOut::where('id', $pay_id)->first();

        if ($pay) {
            if (isset($data['transactionId']) && $data['transactionId'] !== "") {
                $pay->transactionId = stripinput($data['transactionId']);
            }
            if (isset($data['paymentId']) && $data['paymentId'] !== "") {
                $pay->paymentId = stripinput($data['paymentId']);
            }
            if (isset($data['commissionAmount']) && $data['commissionAmount'] !== "") {
                $pay->commissionAmount = (float)$data['commissionAmount'];
            }
            if (isset($data['exchangeRate']) && $data['exchangeRate'] !== "") {
                $pay->exchangeRate = stripinput($data['exchangeRate']);
            }
            if (isset($data['billingAmount']) && $data['billingAmount'] !== "") {
                $pay->billingAmount = stripinput($data['billingAmount']);
            }
            if (isset($data['billingFee']) && $data['billingFee'] !== "") {
                $pay->billingFee = stripinput($data['billingFee']);
            }
            if (isset($data['purposeCode']) && $data['purposeCode'] !== "") {
                $pay->purposeCode = stripinput($data['purposeCode']);
            }
            if (isset($data['billingFee']) && $data['billingFee'] !== "") {
                $pay->billingFee = stripinput($data['billingFee']);
            }
            if (isset($data['bankCode']) && $data['bankCode'] !== "") {
                $pay->bankCode = stripinput($data['bankCode']);
            }
            if (isset($data['paymentDetails']) && $data['paymentDetails'] !== "" && is_json($data['paymentDetails'])) {
                $pay->paymentDetails = $data['paymentDetails'];
            }
            if (isset($data['paymentFields']) && $data['paymentFields'] !== "" && is_json($data['paymentFields'])) {
                $pay->paymentFields = $data['paymentFields'];
            }
            if (isset($data['paymentError']) && $data['paymentError'] !== "") {
                $pay->paymentError = $data['paymentError'];
            }

            if (isset($data['status']) && $data['status'] !== "") {
                $pay->status = $data['status'];
            }

            $pay->save();

            return true;
        } else {
            return false;
        }

    }


    public static function getPay($id) {
        $pay = PayOut::where('id', (int)$id)
            ->first();

        return $pay;

    }
    public static function getPayByUserId($id, $user_id) {
        $pay = PayOut::where('id', (int)$id)
            ->where('user_id', (int)$user_id)
            ->first();

        return $pay;

    }

    public static function getByOrderId($order_id) {

        $order_id = stripinput($order_id);

        $pay = PayOut::where('orderId', $order_id)
            ->where('status', '<=', 1)
            ->first();

        return $pay;

    }

    public static function getByOrderIdAndUserId($paymentId, $user_id) {

        $paymentId = (int)$paymentId;
        $user_id = (int)$user_id;

        $pay = PayOut::where('paymentId', $paymentId)
            ->where('user_id', $user_id)
            ->first();

        return $pay;

    }


    public static function getByUserId($user_id, $limit = 10) {


        $pays = PayOut::where('user_id', (int)$user_id)
            ->where('status', 1)
//            ->limit((int)$limit)
            ->orderBy('id', 'DESC')
            ->paginate($limit);
//            ->get();

        return $pays;

    }

    public static function getByUserIdNoStatus($user_id, $limit = 10) {

        $pays = PayOut::where('user_id', (int)$user_id)
            ->orderBy('id', 'DESC')
            ->paginate($limit);

        return $pays;

    }

    public static function getCountByUserIdNoStatus($user_id) {

        $pays = PayOut::where('user_id', (int)$user_id)
            ->count();

        return $pays;
    }



    public static function getAll($limit = 10) {


        $payOuts = PayOut::select(
            'pay_out.*',
            'users.name as user_name',
            'users.email as user_email',
        )
        ->join('users', 'pay_out.user_id', '=', 'users.id')
        ->orderBy('id', 'DESC')
            ->paginate($limit);


        return $payOuts;

    }


    public static function getSearchAll($limit = 10,$search) {



        $payOuts = PayOut::select(
            'pay_out.*',
            'users.name as user_name',
            'users.email as user_email',
        )
            ->where('users.name', 'like', '%' . $search . '%')
            ->orWhere('users.email', 'like', '%' . $search . '%')
            ->join('users', 'pay_out.user_id', '=', 'users.id')
            ->orderBy('id', 'DESC')
            ->paginate($limit);


        return $payOuts;

    }


    public static function getSearchID($limit = 10,$search) {



        $payOuts = PayOut::select(
            'pay_out.*',
            'users.name as user_name',
            'users.email as user_email',
        )
            ->where('users.id', 'like', $search)
            ->join('users', 'pay_out.user_id', '=', 'users.id')
            ->orderBy('id', 'DESC')
            ->paginate($limit);


        return $payOuts;

    }

}
