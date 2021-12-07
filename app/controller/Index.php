<?php

namespace app\controller;

use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Dingtalk;
use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Models\GetAccessTokenRequest;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTOHeaders;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use app\BaseController;
use Darabonba\OpenApi\Models\Config;
use Throwable;

class Index extends BaseController
{
    public function index()
    {

        $config                           = new Config([]);
        $config->protocol                 = "https";
        $GetAccessTokenRequest            = new GetAccessTokenRequest();
        $GetAccessTokenRequest->appKey    = 'dingdoludk41g62ffoov';
        $GetAccessTokenRequest->appSecret = 'Rol0B6_5JuBRv1KQ7g9Gf0-MaZCoQElG4c-5KR5UMOw7Okr7oE97tXRiLNSmylu3';

        $client = new Dingtalk($config);

        echo '<pre>';
        $accessToken = "";
        try {
            $resp        = $client->getAccessToken($GetAccessTokenRequest);
            $accessToken = $resp->body->accessToken;
            $expireIn    = $resp->body->expireIn;
            print_r("accessToken:" . $accessToken . PHP_EOL);
            print_r("expireIn:" . $expireIn . PHP_EOL);

            $req = new BatchSendOTORequest();

            $req->robotCode = "dingidpy5p1nj0lknlbq";
            $req->userIds   = ["054632473136322716"];    //通过手机号获取userId
            $req->msgKey    = "officialMarkdownMsg";
            $msgParam       = [
                "text"  => "hello 哈哈哈哈",
                "title" => "hello title",
            ];
            $req->msgParam  = (string)json_encode($msgParam);

            print_r($req->toMap());

            $client                          = new \AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Dingtalk($config);
            $header                          = new BatchSendOTOHeaders();
            $header->xAcsDingtalkAccessToken = $accessToken;
            $runtime                         = new RuntimeOptions([]);
            $resp                            = $client->batchSendOTOWithOptions($req, $header, $runtime);
            print_r($resp);
        } catch (Throwable $e) {
            print_r(sprintf(":%s", $e->getMessage()));
        }
    }
}
