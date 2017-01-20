<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 用户管理
*/
class UserController extends BaseController
{
	private $user;

	public function _initialize()
	{
		$this->user = D('User');
	}
	
	public function index()
	{
		$this->display('_index');
	}

	public function demo()
	{
		if (IS_AJAX) {
			$type = I('get.type');
			$p = I('get.p', 1);
			$data = $this->user->getUsers($type, $p);
			exit(json_encode($data));
		}
	}

}