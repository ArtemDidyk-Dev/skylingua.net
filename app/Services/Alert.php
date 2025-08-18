<?php


namespace App\Services;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Alert
{
    public static $data = [];

    public static function success($title = null,$content = null)
    {

        $success = "<script>toastr.success('".$content."','".$title."');</script>";
        self::$data[] = self::alertShare($success);

    }


    public static function error($title = null,$content = null)
    {
        $success = "<script>toastr.error('".$content."','".$title."');</script>";
        self::$data[] = self::alertShare($success);

    }


    public static function warning($title = null,$content = null)
    {
        $success = "<script>toastr.warning('".$content."','".$title."');</script>";
        self::$data[] = self::alertShare($success);
    }


    public static function info($title = null,$content = null)
    {
        $success = "<script>toastr.info('".$content."','".$title."');</script>";
        self::$data[] = self::alertShare($success);
    }

    public static function alertShare($data = null)
    {
        self::$data[] = $data;
        Session::flash('alertToastSuccess', self::$data);

//        view()->share('alertToastSuccess',self::$data);

    }



}
