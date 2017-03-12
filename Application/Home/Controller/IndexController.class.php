<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends BaseController
{
	public function _initialize()
	{
		$permit_id = session(C('USER_AUTH_KEY'));
		if (!isset($permit_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
	}

	
    public function index()
    {
        $this->display('Base/_index');
    }


}