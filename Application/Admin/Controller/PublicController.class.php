<?php
namespace Admin\Controller;
use Think\Controller;
/**
*
*/
class PublicController extends Controller
{

	public function login()
	{
		$auth_id = session(C('USER_AUTH_KEY'));
		if (!isset($auth_id)) {
			$this -> display();
		} else {
			header('Location: ' . __APP__);
		}
	}

	// 登录
	public function check_login()
	{
		$post = I('post.');
		if (empty($post['account'])) {
			$this->error('账号必须！');
		} elseif (empty($post['pwd'])) {
			$this->error('密码必须！');
		}

		if (!D('Admin')->doLogin($post)) {
			$this->error('帐号或密码错误！');
		}
		header('Location: ' . U("index/index"));
	}

	// 登出
	public function logout() {
		$auth_id = session(C('USER_AUTH_KEY'));
		if (isset($auth_id)) {
			session(C('USER_AUTH_KEY'), null);
			session('admin_name', null);
			session('role_id', null);

			redirect(U(C('USER_AUTH_GATEWAY')));
		} else {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
	}

}
