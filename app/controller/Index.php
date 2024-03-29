<?php

namespace app\controller;

use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
use app\BaseController;
use app\logic\DingtalkUtil;
use GuzzleHttp\Client;

class Index extends BaseController
{
    public function index()
    {
        return $this->responseJson();
    }

    public function index1()
    {
        $url = "http://openapi.turingapi.com/openapi/api/v2";
        $client = new Client();
        $jsonData = [
            'reqType' => 0,
            'perception' => [
                'inputText' => [
                    'text' => '你好呀',
                ],
            ],
            'userInfo' => [
                'apiKey' => 'e6425b8d1cfb40ec8a713c989b6faaa9',
                'userId' => '11111111',
            ],
        ];
        $resp = $client->post($url, ['json' => $jsonData]);
        echo '<pre>';
        $content = json_decode($resp->getBody()->getContents(), true);
        print_r($resp->getStatusCode());
        print_r($content);

        foreach ($content['results'] as $item) {
            $item['values']['text'];
        }
    }

    public function is_json($string)
    {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    public function index2()
    {
        $userIds = ["054632473136322716"];
        $robotCode = "dingidpy5p1nj0lknlbq";

        $req = new BatchSendOTORequest();

        $req->robotCode = $robotCode;
        $req->userIds = $userIds;    //通过手机号获取userId
//        $req->msgKey    = "officialMarkdownMsg";
        $req->msgKey = "sampleActionCard";
        $date = date('Y-m-d H:i:s');
        $raw_post_data = file_get_contents('php://input', 'r');
        $txt = '';
        foreach ($_SERVER as $key => $value) {
            $txt .= sprintf("> %s: %s \n\n", $key, $value);
        }
        $msgParam = [
            "title" => '有人请求了',
            "text" => $txt . $raw_post_data . "[{$date}]",
        ];


        $jsonStr = <<<EOF
{
     "title": "测试标题",
     "text": "内容测试",
     "singleTitle": "查看详情",
     "singleURL": "https://open.dingtalk.com"
}
EOF;

        $req->msgParam = $msgParam;
//        $req->msgParam = (string)json_encode($msgParam);
        DingtalkUtil::newInstance()->batchSend($req);
        return $this->responseJson();
    }
}
