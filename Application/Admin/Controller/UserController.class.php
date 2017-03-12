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
		$auth_id = session(C('USER_AUTH_KEY'));
		if (!isset($auth_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
		
		$this->user = D('User');
		$this->assign('current', CONTROLLER_NAME . '/' . ACTION_NAME);
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
			if (!$this->user->create()) {
				$this->error($this->user->getError());
			} else {
				if ($this->user->id) {
					if ($this->user->save()) {
						returnJson(true, '修改成功');
					} else {
						returnJson(false, '修改失败');
					}
				}

				if ($this->user->add()) {
					returnJson(true, '添加成功');
				} else {
					returnJson(false, '添加失败');
				}
			}
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

	public function del()
	{
		if (IS_AJAX) {
			$id = I('get.id');
			$this->user->where(array('id' => $id))->save(array('status' => 0));
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


	public function addDep()
	{
		if (IS_AJAX) {
			$model = D('College');
			if (!$model->create()) {
				$this->error($model->getError());
			} else {
				if ($model->id) {
					if ($model->save()) {
						returnJson(true, '修改成功');
					} else {
						returnJson(false, '修改失败');
					}
				}

				if ($model->add()) {
					returnJson(true, '添加成功');
				} else {
					returnJson(false, '添加失败');
				}
			}
		}
	}


	public function getAllCollege()
	{
		if (IS_AJAX) {
			$data = D('College')->field(array('id', 'name'))->select();
			exit(json_encode($data));
		}
	}


	public function welcome()
	{
		$this->display();
	}


}