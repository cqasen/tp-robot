<?php

namespace app\controller;

use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
use app\BaseController;
use app\logic\DingtalkUtil;
use GuzzleHttp\Client;

class Index extends BaseController
{
    public function index1()
    {
        $url      = "http://openapi.turingapi.com/openapi/api/v2";
        $client   = new Client();
        $jsonData = [
            'reqType'    => 0,
            'perception' => [
                'inputText' => [
                    'text' => '你好呀',
                ],
            ],
            'userInfo'   => [
                'apiKey' => 'e6425b8d1cfb40ec8a713c989b6faaa9',
                'userId' => '11111111',
            ],
        ];
        $resp     = $client->post($url, ['json' => $jsonData]);
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

    public function index()
    {
        $userIds   = ["054632473136322716"];
        $robotCode = "dingidpy5p1nj0lknlbq";

        $req = new BatchSendOTORequest();

        $req->robotCode = $robotCode;
        $req->userIds   = $userIds;    //通过手机号获取userId
        $req->msgKey    = "officialMarkdownMsg";
        $date           = date('Y-m-d H:i:s');
        $raw_post_data  = file_get_contents('php://input', 'r');
        $txt            = '';
        foreach ($_SERVER as $key => $value) {
            $txt .= sprintf("> %s: %s \n\n", $key, $value);
        }
        $msgParam = [
            "title" => '有人请求了',
            "text"  => $txt . $raw_post_data . "[{$date}]",
        ];


        $jsonStr = <<<EOF
{
    "msgtype": "actionCard",
    "actionCard": {
        "title": "乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身", 
        "text": "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划", 
        "btnOrientation": "0", 
        "btns": [
            {
                "title": "内容不错", 
                "actionURL": "https://www.dingtalk.com/"
            }, 
            {
                "title": "不感兴趣", 
                "actionURL": "https://www.dingtalk.com/"
            }
        ]
    }
}
EOF;

        $msgParam = json_decode($jsonStr,true);
        $req->msgParam = (string)json_encode($msgParam);
        DingtalkUtil::newInstance()->batchSend($req);
        return $this->responseJson();
    }
}
