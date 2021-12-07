<?php

namespace app\controller;

use app\BaseController;

class Reply extends BaseController
{
	public function index()
	{
		echo "<pre>";
		$raw_post_data = file_get_contents('php://input', 'r');
		print_r($raw_post_data);
	}
}
