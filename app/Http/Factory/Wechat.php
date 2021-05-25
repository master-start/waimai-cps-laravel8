<?php
namespace App\Http\Factory;

use App\Handlers\WechatHandler;

class Wechat
{
    public static function miniProgram(){
        return new WechatHandler();
    }
}
