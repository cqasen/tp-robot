<?php

namespace app\logic;

use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Dingtalk;
use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Models\GetAccessTokenRequest;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTOHeaders;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\SendRobotDingMessageHeaders;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\SendRobotDingMessageRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use app\base\NewInstanceTrait;
use Darabonba\OpenApi\Models\Config;
use think\facade\Log;
use Throwable;

class DingtalkUtil
{
	use NewInstanceTrait;

	public function getAccessToken()
	{
		$config                           = new Config([]);
		$config->protocol                 = "https";
		$getAccessTokenRequest            = new GetAccessTokenRequest();
		$getAccessTokenRequest->appKey    = 'dingdoludk41g62ffoov';
		$getAccessTokenRequest->appSecret = 'Rol0B6_5JuBRv1KQ7g9Gf0-MaZCoQElG4c-5KR5UMOw7Okr7oE97tXRiLNSmylu3';

		$client = new Dingtalk($config);
		try {
			$resp        = $client->getAccessToken($getAccessTokenRequest);
			$accessToken = $resp->body->accessToken;
		} catch (Throwable $e) {
			Log::error($e->getMessage());
			throw $e;
		}
		return $accessToken;
	}

	/**
	 * @param BatchSendOTORequest $req
	 * @return bool
	 * @throws Throwable
	 *
	 */
	public function batchSend(BatchSendOTORequest $req)
	{
		try {
			$accessToken = $this->getAccessToken();

			$config                          = new Config([]);
			$config->protocol                = "https";
			$client                          = new \AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Dingtalk($config);
			$header                          = new BatchSendOTOHeaders();
			$header->xAcsDingtalkAccessToken = $accessToken;
			$runtime                         = new RuntimeOptions([]);
			$client->batchSendOTOWithOptions($req, $header, $runtime);
		} catch (Throwable $e) {
			Log::error($e->getMessage());
			throw $e;
		}
		return true;

	}


	/**
	 * @param SendRobotDingMessageRequest $req
	 * @return bool
	 * @throws Throwable
	 */
	public function sendRobotDingMessage(SendRobotDingMessageRequest $req)
	{
		try {
			$accessToken                     = $this->getAccessToken();
			$config                          = new Config([]);
			$config->protocol                = "https";
			$client                          = new \AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Dingtalk($config);
			$header                          = new SendRobotDingMessageHeaders();
			$header->xAcsDingtalkAccessToken = $accessToken;
			$runtime                         = new RuntimeOptions([]);
			$client->sendRobotDingMessageWithOptions($req, $header, $runtime);
		} catch (Throwable $e) {
			Log::error($e->getMessage());
			print_r($e->getMessage());
			throw $e;
		}
		return true;
	}
}
