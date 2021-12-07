<?php

namespace app\controller;

use app\BaseController;
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

	}
}
