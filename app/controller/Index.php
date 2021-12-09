<?php

namespace app\controller;

use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
use app\BaseController;
use app\logic\DingtalkUtil;

class Index extends BaseController
{
	public function index()
	{
		$userIds   = ["054632473136322716"];
		$robotCode = "dingpekecjsl8bjfiy2u";

		$req = new BatchSendOTORequest();

		$req->robotCode = $robotCode;
		$req->userIds   = $userIds;    //通过手机号获取userId
		$req->msgKey    = "officialMarkdownMsg";
		$date           = date('Y-m-d H:i:s');
		$msgParam       = [
			"title" => '工单消息通知',
			"text"  => <<<EOF
<font color=#349805 >【工单消息通知】</font>

您创建的工单已经开始处理！

工单号：Q20210719003

优先级： <font color=#EB2424 >紧急</font>

分类：技术-订单

主题：订单创建推送仓库之后，仓库人员无法查询。

操作人：测试人员A

操作时间:{$date}

详情查看：[浏览器打开](https://www.epet.com/) [钉钉打开](https://www.epet.com/)
EOF
			,
		];
		$req->msgParam  = (string)json_encode($msgParam);
		DingtalkUtil::newInstance()->batchSend($req);
		return $this->responseJson();
	}
}
