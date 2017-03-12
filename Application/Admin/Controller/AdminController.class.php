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
		$auth_id = session(C('USER_AUTH_KEY'));
		if (!isset($auth_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
		
		$this->role = D('Role');
		$this->admin = D('Admin');
		$this->assign('current', CONTROLLER_NAME . '/' . ACTION_NAME);
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


	// 添加/修改管理员
	public function addUser()
	{
		if (IS_AJAX) {
			if (!$this->admin->create()) {
                $this->error($this->admin->getError());
            } else {
            	if ($this->admin->id) {
            		$handle = $this->admin->save();
            	} else {
            		$handle = $this->admin->add();
            	}

                if ($handle) {
                    returnJson(true, '添加成功');
                } else {
                	echo $this->admin->getlastsql();
                    returnJson(false, '添加失败');
                }
            }
		}

		$this->display();
	}


	// 删除管理员
	public function delUser()
	{
		if (IS_AJAX) {
			$id = I('get.id');
			if ($this->admin->where(array('id' => $id))->save(array('status' => 0))) {
				echo 1;
			} else {
				echo 0;
			}
		}
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


	public function nodes()
	{
		if (IS_AJAX) {
			$rid = I('get.rid', 0);
			if ($rid) {
				$data = M('RoleMenu')->where(array('rid' => $rid))->getField('mid');
				if ($data) {
					$data = explode(',', $data);
				} else {
					$data = array();
				}
				
			} else {
				$data = M('Menu')->where(array('pid' => 0))->field(array('id', 'title'))->select();
			}
			exit(json_encode($data));
		}
	}


	// 给角色设置权限
	public function saveAuth()
	{
		if (IS_AJAX) {
			$post = I('post.');
			$mid = implode(',', $post['mid']);
			$data = array(
				'rid' => $post['rid'],
				'mid' => $mid
			);

			$model = M('RoleMenu');
			$model->where(array('rid' => $post['rid']))->delete();
			if ($model->add($data)) {
				echo 1;
			} else {
				echo 0;
			}
		}
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


	public function getAllAdmin()
	{
		if (IS_AJAX) {
			$data = $this->admin->where(array('status' => 1))->field(array('id', 'account'))->select();
			exit(json_encode($data));
		}
	}


	// 获取负责人
	public function getHeadByCid()
	{
		if (IS_AJAX) {
			$id = I('get.id');
			$data = D('College')->getHeadByCid($id);
			exit(json_encode($data));
		}
	}


	// 为学院设置管理员(负责人)
	public function setAdminForCid()
	{
		if (IS_AJAX) {
			$uid = I('post.uid');
			$id = I('post.id');
			if (D('College')->setHeadForCid($uid, $id)) {
				returnJson(true, '分配成功');
			} else {
				returnJson(false, '分配失败');
			}
		}
	}






}
