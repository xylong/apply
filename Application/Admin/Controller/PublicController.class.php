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

	public function check_login()
	{
		$post = I('post.');
		if (empty($post['name'])) {
			$this -> error('帐号必须！');
		} elseif (empty($_POST['password'])) {
			$this -> error('密码必须！');
		}

		$map = array(
			'account' 	=> $post['account'],
			'password' 	=> md5($post['account']),
			'is_del'	=> 0
		);
		$model = M("User");
		$auth_info = $model -> where($map) -> find();
		
		if (false == $auth_info) {
			$this -> error('帐号或密码错误！');
		} else {
			session(C('USER_AUTH_KEY'), $auth_info['id']);
			session('emp_no', $auth_info['emp_no']);
			session('user_name', $auth_info['name']);
			session('user_pic', $auth_info['pic']);
			session('dept_id', $auth_info['dept_id']);

			//保存登录信息
			$User = M('User');
			$ip = get_client_ip();
			$time = time();
			$data = array();
			$data['id'] = $auth_info['id'];
			$data['last_login_time'] = $time;
			$data['login_count'] = array('exp', 'login_count+1');
			$data['last_login_ip'] = $ip;
			$User -> save($data);
			$this -> assign('jumpUrl', U("index/index"));
			header('Location: ' . U("index/index"));
		}
	}

}