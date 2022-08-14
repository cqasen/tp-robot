<?php
declare (strict_types=1);

namespace app\controller;

use app\BaseController;
use think\Request;
use EasyWeChat\MiniProgram\Application;
use EasyWeChat\Kernel\Exceptions\DecryptException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use think\response\Json;

/**
 * 登录
 */
class Auth extends BaseController
{
    /**
     * 登录
     * @param Request $request
     * @return Json
     * @throws DecryptException
     * @throws InvalidConfigException
     */
    public function login(Request $request)
    {
        $code = $request->post('code');
        $iv = $request->post('iv');
        $encryptedData = $request->post('encryptedData');
        /**
         * @var Application $miniProgram
         */
        $miniProgram = app('miniProgram');
        $wxInfo = $miniProgram->auth->session($code);
        $decryptedData = [];
        if (isset($wxInfo['errcode']) && $wxInfo['errcode'] != 0) {

        } else {
            /**
             * {"openId":"oCkbm5HU63Kcdx9xJbegC-4TWRbA","nickName":"森","gender":1,"language":"zh_CN","city":"北碚","province":"重庆","country":"中国","avatarUrl":"https://thirdwx.qlogo.cn/mmopen/vi_32/MJdzHRsaDY5WaL0n5YC0hpJxWOJTLcfkr7RRLWO9LCS2RyOkAGzDKres7Jx9IQJpIhR9MYh8kEZzIXibOJ1JEmA/132","watermark":{"timestamp":1611498927,"appid":"wxb85794a35a0430b4"}}
             */
            $decryptedData = $miniProgram->encryptor->decryptData($wxInfo['session_key'], $iv, $encryptedData);
        }

        return $this->responseJson($wxInfo);
    }

}
