<?php

namespace app\logic;

use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Dingtalk;
use AlibabaCloud\SDK\Dingtalk\Voauth2_1_0\Models\GetAccessTokenRequest;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTOHeaders;
use AlibabaCloud\SDK\Dingtalk\Vrobot_1_0\Models\BatchSendOTORequest;
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
        $getAccessTokenRequest->appKey    = 'dingidpy5p1nj0lknlbq';
        $getAccessTokenRequest->appSecret = 'zUm5-mqD6amYeykQRghfnqATwjpoYvoQTGYyvnIbb7b3uFHPYj6zAc1XARUnb2CV';

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
}
