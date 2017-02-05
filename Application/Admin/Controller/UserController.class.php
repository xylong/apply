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


	public function addUser()
	{
		if (IS_AJAX) {
			$post = I('post.');
			exit(json_encode($post));
		}
		$this->display('add');
	}


	// 获取用户信息
	public function getUserInfo()
	{
		if (IS_AJAX) {
			$id = I('get.id');
			$data = $this->user->getuserInfo($id);
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


	public function getAllCollege()
	{
		if (IS_AJAX) {
			$data = D('College')->field(array('id', 'name'))->select();
			exit(json_encode($data));
		}
	}


}