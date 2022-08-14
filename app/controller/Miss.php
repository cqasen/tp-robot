<?php
declare (strict_types=1);

namespace app\controller;

use app\BaseController;
use think\Request;

class Miss extends BaseController
{
    /**
     * @return \think\response\Json
     */
    public function index()
    {
        return $this->responseJson([], 404, '404 Not Found!');
    }

}
