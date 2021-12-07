<?php

namespace app\controller;

use app\BaseController;
use app\logic\DingtalkUtil;
use Throwable;

class Index extends BaseController
{
	public function index()
	{
		$userIds = ["054632473136322716"];    //通过手机号获取userId
		$message = "简单操作";
		DingtalkUtil::newInstance()->batchSend($userIds, $message);
	}
}
