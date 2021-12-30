<?php

namespace app\controller;

use app\BaseController;
use app\dto\ChatbotReplyDto;
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
        Log::write($_SERVER, 'notice');
        $appSecret = "zUm5-mqD6amYeykQRghfnqATwjpoYvoQTGYyvnIbb7b3uFHPYj6zAc1XARUnb2CV";
        //sign 与计算的结果不一致，则认为是非法的请求。
        $timestamp    = time() * 1000;
        $stringToSign = $timestamp . '\n' . $appSecret;
        $signRes      = hash_hmac('sha256', $stringToSign, $appSecret);
        $signRes      = base64_encode($signRes);
        Log::write('', 'notice', [
            'stringToSign'   => $stringToSign,
            'signRes'        => $signRes,
            'HTTP_TIMESTAMP' => $_SERVER['HTTP_TIMESTAMP'],
            'HTTP_TOKEN'     => $_SERVER['HTTP_TOKEN'],
            'HTTP_SIGN'      => $_SERVER['HTTP_SIGN'],
            'time_diff'      => ($timestamp - $_SERVER['HTTP_TIMESTAMP']) / 3600,
        ]);

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

        $dto     = ChatbotReplyDto::newInstance($params);
        $userIds = [];
        $dto->getSenderStaffId() && $userIds[] = $dto->getSenderStaffId();
        $url = $dto->getSessionWebhook();
        try {
            $turingapi = "http://openapi.turingapi.com/openapi/api/v2";
            $client    = new Client();
            $jsonData  = [
                'reqType'    => 0,
                'perception' => [
                    'inputText' => [
                        'text' => $dto->getText()['content'] ?? '',
                    ],
                ],
                'userInfo'   => [
                    'apiKey' => 'e6425b8d1cfb40ec8a713c989b6faaa9',
                    'userId' => md5($dto->getSenderStaffId()),
                ],
            ];
            $resp      = $client->post($turingapi, ['json' => $jsonData]);
            $content   = json_decode($resp->getBody()->getContents(), true);

            foreach ($content['results'] as $item) {
                if (($content['intent']['code'] ?? 0) == 4003) {
                    $message = sprintf('你于[%s]发送的消息为：%s', date('Y-m-d H:i:s', $dto->getCreateAt() / 1000),
                        $dto->getText()['content'] ?? '');
                } else {
                    $message = $item['values']['text'] ?? '抱歉呢，没有理解你说的';
                }
                $this->sendReply($url, $message, $userIds);
            }
        } catch (\Throwable $e) {
            Log::error($e->getMessage());

            $message = sprintf('你于[%s]发送的消息为：%s', date('Y-m-d H:i:s', $dto->getCreateAt() / 1000),
                $dto->getText()['content'] ?? '');
            $this->sendReply($url, $message, $userIds);
        }

        return $this->responseJson();

    }

    /**
     * @param $url
     * @param $message
     * @param $userIds
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function sendReply($url, $message, $userIds): void
    {
        $client = new Client();

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
        $resp     = $client->post($url, ['json' => $jsonData]);
    }
}
