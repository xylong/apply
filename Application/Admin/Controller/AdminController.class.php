<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 用户管理
*/
class AdminController extends BaseController
{
	private $role;
	private $admin;

	public function _initialize()
	{
		$this->role = D('Role');
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
			$data = $this->role->getRole();
			exit(json_encode($data));
		}
		$this->display();
	}


	// 添加、删除角色
	public function editRole()
	{
		if (IS_AJAX) {
			if (!$this->role->create()) {
                $this->error($this->role->getError());
            } else {
                if ($this->role->id) {
                    $handle = $this->role->save();
                } else {
                    unset($this->role->id);
                    $handle = $this->role->add();
                }
                if ($handle) {
                    returnJson(true, '角色保存成功');
                } else {
                    returnJson(false, '角色保存失败');
                }
            }
		}
	}


	// 分配权限
	public function allot()
	{
		if (IS_AJAX) {
			$role_id = I('post.role_id');
			$uid = I('post.user_id');
			
			if ($this->role->assignAuth($role_id, $uid)) {
				returnJson(true, '分配成功');
			} else {
				returnJson(false, '分配失败');
			}
		}
	}


	// 获取权限
	public function getPermission()
	{
		if (IS_AJAX) {
			$user_id = I('get.user_id');
			$data = $this->role->permission($user_id);
			exit(json_encode($data));
		}
	}



}
