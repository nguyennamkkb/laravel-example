<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CmdController extends Controller
{
    public static function GetIduser()
    {
        $date = new \DateTime();
        
        $iduser = md5(rand(10,99)."?@c" . $date->getTimestamp() . rand(10,99)."*!)");    

        return strtoupper($iduser);
    }
    public static function getCode()
    {
        $code = intval(rand(100000,999999));
        return $code;

    }
    public static function getDateTime()
    {
        $date = new \DateTime();
        $today = new \DateTime();
        $datetimeFormat = 'Y-m-d H:i:s';
        $date = $date->getTimestamp();
        $today->setTimestamp($date);
        $today = $today->format($datetimeFormat);


        return $today;
    }
    public static function formatNumberCur($str)
    {
        $num = number_format($str, 0, ',', '.');
        return $num;
    }
    
    public static function replaceNumberFormat($str)
    {
        $num = str_replace('.','',$str);
        return $num;
    }

}
