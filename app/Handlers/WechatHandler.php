<?php

namespace App\Handlers;

use EasyWeChat\Factory;

class WechatHandler
{
    protected $app;

    public function __construct()
    {
        $config = [
            'app_id' => env('WECHAT_MINI_PROGRAM_APPID'),
            'secret' => env('WECHAT_MINI_PROGRAM_SECRET'),

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];

        $this->app = Factory::miniProgram($config);
    }

    public function server(){
        return $this->app;
    }
}
