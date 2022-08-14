<?php

namespace app\service;
use EasyWeChat\Factory;

class MiniProgramService extends \think\Service
{
    public function register(): void
    {
        $config = [
            'app_id' => env('MINI_PROGRAM.APP_ID'),
            'secret' => env('MINI_PROGRAM.SECRET'),

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];

        $this->app->bind('miniProgram', Factory::miniProgram($config));
    }

    public function boot(): void
    {

    }
}