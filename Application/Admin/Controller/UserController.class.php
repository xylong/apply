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
			$data = $this->user->getUsers($type);
			exit(json_encode($data));
		}
	}

}