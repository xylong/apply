<?php
namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class PublicController extends Controller
{

	public function login()
	{
		$permit_id = session(C('USER_AUTH_KEY'));
		if (!isset($permit_id)) {
			$this -> display();
		} else {
			header('Location: ' . __APP__);
		}
	}

	public function check_login()
	{
		// $is_verify_code = get_system_config("IS_VERIFY_CODE");
		// if (!empty($is_verify_code)) {
		// 	$check = $this -> check_verify($_POST['verify'], 1);
		// 	if (!$check) {
		// 		$this -> error('验证码错误！');
		// 	}
		// }

		$post = I('post.');
		if (empty($post['username'])) {
			$this->error('账号必须！');
		} elseif (empty($post['password'])) {
			$this->error('密码必须！');
		}

		if (D('User')->doLogin($post)) {
			$this->error('帐号或密码错误！');
		}
		header('Location: ' . U("index/index"));
	}

	// 登出
	public function logout() {
		$auth_id = session(C('USER_AUTH_KEY'));
		if (isset($auth_id)) {
			session(C('USER_AUTH_KEY'), null);
			session('username', null);
			session('utype', null);

			redirect(U(C('USER_AUTH_GATEWAY')));
		} else {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
	}

}