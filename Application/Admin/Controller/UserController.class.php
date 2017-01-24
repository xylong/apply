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

	// 用户列表
	public function users()
	{
		if (IS_AJAX) {
			$type = I('get.type');
			$p = I('get.p', 1);
			$keyword = I('get.keyword', '', 'trim');
			$data = $this->user->getUsers($type, $p, $keyword);
			exit(json_encode($data));
		}
	}

	// 学院列表
	public function colleges()
	{
		if (IS_AJAX) {
			$p = I('get.p', 1);
			$keyword = I('get.keyword', '', 'trim');
			$data = D('College')->getColleges($p, $keyword);
			exit(json_encode($data));
		}

		$this->display();
	}


}