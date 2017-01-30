<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 用户管理
*/
class AdminController extends BaseController
{
	private $admin;

	public function _initialize()
	{
		$this->admin = D('Admin');
	}

	public function index()
	{
		if (IS_AJAX) {
			$p = I('get.p', 1);
			$keyword = I('get.keyword', '', 'trim');
			$data = $this->admin->getUsers($p, $keyword);
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	// 角色列表
	public function role()
	{
		if (IS_AJAX) {
			# code...
		}
		$this->display();
	}



}
