<?php

namespace app\controller;

use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
use app\BaseController;
use app\logic\DingtalkUtil;
use Throwable;

class Index extends BaseController
{
	public function index()
	{
        $userIds = [""];
        $robotCode = "dingpekecjsl8bjfiy2u";

        $req = new BatchSendOTORequest();

        $req->robotCode = $robotCode;
        $req->userIds   = $userIds;    //通过手机号获取userId
        $req->msgKey    = "officialMarkdownMsg";
        $msgParam       = [
            "text"  => "111",
            "title" => "2222",
        ];
        $req->msgParam  = (string)json_encode($msgParam);
        DingtalkUtil::newInstance()->batchSend($req);
	}
}
