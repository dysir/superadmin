<?php
require 'vendor/autoload.php';
use PragmaRX\Google2FA\Google2FA;

class Gfa
{
    // 验证
    public static function vali($skey, $code)
    {
        $google2fa = new Google2FA();
        $TimeStamp = $google2fa->getTimestamp();

        
        $secretkey = $google2fa->base32Decode($skey);
        $otp = $google2fa->oathHotp($secretkey, $TimeStamp);

        $is_pass = $google2fa->verifyKey($skey, $code);
        $is_pass = $otp == $code ? true : false;
        if (! $is_pass) {
            return false;
        }
        return true;
    }
    // 生成二维码内容的信息
    public static function gqr($skey)
    {
        $google2fa = new Google2FA();
        $qr = $google2fa->getQRCodeUrl("dysir".mt_rand(0,100), "@dysir.com", $skey);
        return $qr;
    }
}