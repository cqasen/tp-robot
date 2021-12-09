<?php

namespace app\controller;

use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
use app\BaseController;
use app\dto\ChatbotReplyDto;
use app\logic\DingtalkUtil;
use GuzzleHttp\Client;
use think\facade\Log;

class Reply extends BaseController
{
	public function is_json($string)
	{
		json_decode($string);
		return (json_last_error() === JSON_ERROR_NONE);
	}

	public function index()
	{
//		echo "<pre>";
		$raw_post_data = file_get_contents('php://input', 'r');
//		print_r($raw_post_data);

		$params = $this->is_json($raw_post_data) ? json_decode($raw_post_data, true) : [];
		Log::write($raw_post_data, 'notice', $params);
		$s = '{
	"conversationId": "cidCw9/y/XHOFrDYUrmJ90HfHEYGVSm7Zpv3Q435p+55rY=",
	"chatbotCorpId": "ding3cfda54ade83516bf2c783f7214b6d69",
	"chatbotUserId": "$:LWCP_v1:$Q/1KdmazjrZaVEfMW7fBR7onFhlcKnh1",
	"msgId": "msgEno58HmgtKvZlXdoD86q0g==",
	"senderNick": "森",
	"isAdmin": true,
	"senderStaffId": "054632473136322716",
	"sessionWebhookExpiredTime": 1639049867594,
	"createAt": 1639044467345,
	"senderCorpId": "ding3cfda54ade83516bf2c783f7214b6d69",
	"conversationType": "1",
	"senderId": "$:LWCP_v1:$hnDL6J3jSFO1+VXckD8/zQ==",
	"sessionWebhook": "https://oapi.dingtalk.com/robot/sendBySession?session=fade1c4bc8a37e4b1a27ce969e8029ff",
	"text": {
		"content": "11"
	},
	"robotCode": "dingpekecjsl8bjfiy2u",
	"msgtype": "text"
}';
//		$params = json_decode($s, true);
//		print_r($params);
		$dto       = ChatbotReplyDto::newInstance($params);
		$robotCode = $dto->getRobotCode() ?: 'dingpekecjsl8bjfiy2u';
		$userIds[] = $dto->getSenderStaffId() ?: "054632473136322716";
		if ($dto->getConversationType() == 2) {
			//群聊
			$client   = new Client();
			$message  = sprintf('你于[%s]发送的消息为：%s', date('Y-m-d H:i:s', $dto->getCreateAt() / 1000),
				$dto->getText()['content'] ?? '');
			$jsonData = [
				'msgtype' => 'text',
				'text'    => [
					'content' => $message,
				],
				'at'      => [
					'atMobiles' => [],
					'atUserIds' => $userIds,
					'isAtAll'   => false,
				],
			];
			$resp     = $client->post($dto->getSessionWebhook(), ['json' => $jsonData]);
		} else {
			//单聊
			$message = sprintf('你于[%s]发送的消息为：%s', date('Y-m-d H:i:s', $dto->getCreateAt() / 1000),
				$dto->getText()['content'] ?? '');

			$req = new BatchSendOTORequest();

			$req->robotCode = $robotCode;
			$req->userIds   = $userIds;    //通过手机号获取userId
			$req->msgKey    = "officialMarkdownMsg";
			$date           = date('Y-m-d H:i:s', $dto->getCreateAt() / 1000);
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

当前时间：{$date}

详情查看：[浏览器打开](https://www.epet.com/) [钉钉打开](https://www.epet.com/)
EOF
				,
			];
			$req->msgParam  = (string)json_encode($msgParam);
			Log::write('通知的人', 'notice', $userIds);
			DingtalkUtil::newInstance()->batchSend($req);
		}
		return $this->responseJson();

	}
}
