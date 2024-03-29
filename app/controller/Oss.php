<?php


namespace app\controller;

use app\BaseController;

class Oss extends BaseController
{
	public function getSign()
	{
		$id   = config('Oss')['accessKeyId'];
		$key  = config('Oss')['accessKeySecret'];
		$host = config('Oss')['host'];
		$dir  = config('Oss')['dir'];

		$now        = time();
		$expire     = 120;  //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问。
		$end        = $now + $expire;
		$expiration = date("Y-m-d\TH:i:s\Z", $end);

		//最大文件大小.用户可以自己设置
		$condition    = [0 => 'content-length-range', 1 => 0, 2 => 1048576000];
		$conditions[] = $condition;

		// 表示用户上传的数据，必须是以$dir开始，不然上传会失败，这一步不是必须项，只是为了安全起见，防止用户通过policy上传到别人的目录。
		$start        = [0 => 'starts-with', 1 => '$key', 2 => $dir];
		$conditions[] = $start;

		$arr            = ['expiration' => $expiration, 'conditions' => $conditions];
		$policy         = json_encode($arr);
		$base64_policy  = base64_encode($policy);
		$string_to_sign = $base64_policy;
		$signature      = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

		$response              = [];
		$response['accessid']  = $id;
		$response['host']      = $host;
		$response['policy']    = $base64_policy;
		$response['signature'] = $signature;
		$response['expire']    = $end;
		$response['dir']       = $dir;  // 这个参数是设置用户上传文件时指定的前缀。

		return $this->responseJson($response);
	}
}
