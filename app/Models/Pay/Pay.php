<?php

namespace App\Models\Pay;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $table = 'pays';
    protected $primaryKey = 'id';
    protected $guarded = [];


    public static function addPay($data = [])
    {

        $pay = Pay::create([
            'employer_id' => (int)$data['employer_id'],
            'freelancer_id' => (int)$data['freelancer_id'],
            'project_id' => (int)$data['project_id'],
            'type' => (int)$data['type'],
            'amount' => (float)$data['amount'],
            'currency' => (int)$data['currency'],
            'status' => 0
        ]);

        return $pay;

    }

    public static function editPay($pay_id, $data = [])
    {

        $pay = Pay::where('id', $pay_id)->first();

        if ($pay) {
            if (isset($data['orderId']) && !empty($data['orderId'])) {
                $pay->orderId = stripinput($data['orderId']);
            }

            if (isset($data['code']) && $data['code'] !== "") {
                $pay->code = (int)$data['code'];
            }

            if (isset($data['status']) && $data['status'] !== "") {
                $pay->status = $data['status'];
            }

            if (isset($data['paid_on']) && $data['paid_on'] !== "") {
                $pay->paid_on = $data['paid_on'];
            }

            $pay->save();

            return true;
        } else {
            return false;
        }

    }

    public static function editPayByOrderId($order_id, $data = [])
    {
        $order_id = stripinput(strip_tags($order_id));

        $pay = Pay::where('orderId', $order_id)->first();

        if ($pay) {

            if (isset($data['code']) && !empty($data['code'])) {
                $pay->code = (int)$data['code'];
            }

            if (isset($data['status']) && !empty($data['status'])) {
                $pay->status = $data['status'];
            }

            $pay->save();

            return true;
        } else {
            return false;
        }

    }


    public static function getByOrderId($order_id) {

        $order_id = stripinput($order_id);

        $pay = Pay::where('orderId', $order_id)->first();

        return $pay;

    }


    public static function getByFreelancerId($user_id, $limit = 10) {


        $pays = Pay::where('freelancer_id', (int)$user_id)
            ->where('status', 1)
//            ->limit((int)$limit)
            ->orderBy('id', 'DESC')
            ->paginate($limit);
//            ->get();

        return $pays;

    }

    public static function getByFreelancerIdAndProjectId($user_id, $project_id) {

        $pay = Pay::where('freelancer_id', (int)$user_id)
            ->where('project_id', $project_id)
            ->first();

        return $pay;

    }

    public static function getByEmployerId($user_id, $limit = 10) {

        $pays = Pay::select(
                'pays.*',
                'users.name as user_name',
                'users.profile_photo as user_profile_photo',
                'projects.name as project_name'
            )
            ->leftJoin('users', 'pays.freelancer_id', '=', 'users.id')
            ->leftJoin('projects', 'pays.project_id', '=', 'projects.id')
            ->where('pays.employer_id', (int)$user_id)
            ->orderBy('pays.id', 'DESC')
            ->paginate($limit);

        return $pays;

    }


    public static function getAll($limit = 10) {


        $pays = Pay::select(
            'pays.*',
            'ue.name as employer_name',
            'uf.name as freelancer_name',
        )
            ->leftJoin('users as ue', 'pays.employer_id', '=', 'ue.id')
            ->leftJoin('users as uf', 'pays.freelancer_id', '=', 'uf.id')
            ->orderBy('id', 'DESC')
            ->paginate($limit);
//            ->get();

        return $pays;

    }

    public static function getAllFrelancerPays($user_id) {

        $pays = Pay::where('freelancer_id', (int)$user_id)
            ->get();

        return $pays;

    }

}
