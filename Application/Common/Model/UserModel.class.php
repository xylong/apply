<?php
namespace Common\Model;
use Think\Model;

class UserModel extends Model
{

	public function doLogin($data)
	{
		$password = md5($data['password']);
		$map1 = array('account' => $data['username'], 'password' => $password, 'status' => 1);
		$map2 = array('username' => $data['username'], 'password' => $password, 'status' => 1);

		if ($user_info = $this->where($map1)->find()) {
			$this->setAuthInfo($user_info);
		} elseif ($user_info = $this->where($map2)->find()) {
			$this->setAuthInfo($user_info);
		} else {
			return false;
		}
	}


	private function setAuthInfo($data)
	{
		session(C('USER_AUTH_KEY'), $data['id']);
		session('username', $data['account']);
		session('utype', $data['type']);

		$time = time();
		$_data = array(
			'id' => $data['id'],
			'last_login_time' => date('Y-m-d H:i:s', time())
		);
		$this->save($_data);
		return true;
	}

}