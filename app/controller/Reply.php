<?php

namespace app\controller;

use app\BaseController;
use app\dto\ChatbotReplyDto;
use app\logic\DingtalkUtil;
use think\facade\Log;

class Reply extends BaseController
{
	public function index()
	{
		echo "<pre>";
		$raw_post_data = file_get_contents('php://input', 'r');
		print_r($raw_post_data);
		Log::write('Reply', 'notice');
		Log::write($raw_post_data, 'notice');
		$params = json_decode($raw_post_data, true);
		$dto    = ChatbotReplyDto::newInstance($params);
		Log::write($raw_post_data, 'notice', $dto->toArray());
		$userIds[]        = $dto->getSenderStaffId();
		$conversationType = $dto->getConversationType() === 2 ? '群聊' : '单聊';
		$message          = sprintf('[%s]你于[%s]发送的消息为：%s', $conversationType, date('Y-m-d H:i:s', $dto->getCreateAt()),
			$dto->getText()['content']);
		DingtalkUtil::newInstance()->batchSend($userIds, $message);
	}
}
