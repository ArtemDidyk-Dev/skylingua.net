<?php


namespace App\Services;


class AlertSweet
{
    public static $data = '';

    public static function success($title = null,$content = null)
    {

        $success = "<script>Swal.fire('".$title."','".$content."','success');</script>";
        self::$data = self::alertShare($success);

    }


    public static function error($title = null,$content = null)
    {
        $success = "<script>Swal.fire('".$title."','".$content."','error');</script>";
        self::$data = self::alertShare($success);

    }


    public static function warning($title = null,$content = null)
    {
        $success = "<script>Swal.fire('".$title."','".$content."','warning');</script>";
        self::$data = self::alertShare($success);
    }


    public static function info($title = null,$content = null)
    {
        $success = "<script>Swal.fire('".$title."','".$content."','info');</script>";
        self::$data = self::alertShare($success);
    }

    public static function alertShare($data = null)
    {
        self::$data = $data;
        view()->share('sweetAlertSuccess',self::$data);

    }



}
