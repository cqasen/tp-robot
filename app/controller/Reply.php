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
	public function index()
	{
//		echo "<pre>";
		$raw_post_data = file_get_contents('php://input', 'r');
//		print_r($raw_post_data);
		Log::write('Reply', 'notice');
		Log::write($raw_post_data, 'notice');
		$params = json_decode($raw_post_data, true);
//
//		$s      = ' {"conversationId":"cidslUbes2wg1RUOkAM7Ky0BA==","atUsers":[{"dingtalkId":"$:LWCP_v1:$K42eHOm8++kOBHyyBiNVLQqI4W7KQzSV"}],"chatbotCorpId":"ding5b06cf33b246469235c2f4657eb6378f","chatbotUserId":"$:LWCP_v1:$K42eHOm8++kOBHyyBiNVLQqI4W7KQzSV","msgId":"msgmwAH1b2eCUKS+XIORAPtNQ==","senderNick":"森","isAdmin":true,"senderStaffId":"054632473136322716","sessionWebhookExpiredTime":1638974911889,"createAt":1638969511621,"senderCorpId":"ding5b06cf33b246469235c2f4657eb6378f","conversationType":"2","senderId":"$:LWCP_v1:$hnDL6J3jSFO1+VXckD8/zQ==","conversationTitle":"机器人-TEST","isInAtList":true,"sessionWebhook":"https://oapi.dingtalk.com/robot/sendBySession?session=7c22be0369674062ac1f719114c9ced9","text":{"content":"[忍者] "},"robotCode":"dingidpy5p1nj0lknlbq","msgtype":"text"}';
//		$params = json_decode($s, true);
//		print_r($params);
		$dto = ChatbotReplyDto::newInstance($params);
		Log::write($raw_post_data, 'notice', $dto->toArray());
		$robotCode = 'dingidpy5p1nj0lknlbq';
		$userIds[] = $dto->getSenderStaffId();
		if ($dto->getConversationType() == 2) {
			//群聊
			$client   = new Client();
			$message  = sprintf('你于[%s]发送的消息为：%s', date('Y-m-d H:i:s', $dto->getCreateAt() / 1000),
				$dto->getText()['content']);
			$jsonData = [
				'msgtype' => 'text',
				'text'    => [
					'content' => $message,
				],
				'at'      => [
					'atMobiles' => [],
					'atUserIds' => [
						$dto->getSenderStaffId(),
					],
					'isAtAll'   => false,
				],
			];
			$resp     = $client->post($dto->getSessionWebhook(), ['json' => $jsonData]);
		} else {
			//单聊
			$message = sprintf('你于[%s]发送的消息为：%s', date('Y-m-d H:i:s', $dto->getCreateAt() / 1000),
				$dto->getText()['content']);

			$req = new BatchSendOTORequest();

			$req->robotCode = $robotCode;
			$req->userIds   = $userIds;    //通过手机号获取userId
			$req->msgKey    = "officialMarkdownMsg";
			$msgParam       = [
				"text"  => $message,
				"title" => $message,
			];
			$req->msgParam  = (string)json_encode($msgParam);
			DingtalkUtil::newInstance()->batchSend($req);
		}
		return $this->responseJson();

	}
}
