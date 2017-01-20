<?php
namespace Common\Model;
use Think\Model;

class UserModel extends Model
{

	public function getUsers($type)
	{
		$map = array('type' => $type);

		$Page = new \Think\Page($count, 10);
		$count = $this->where($map)->count();
		$rows = $this->page($page, 10)->where($map)->field(array('id', 'account', 'cid', 'nickname', 'phone'))->order('id')->select();

		return array(
			'data' => $rows,
			'count' => $count
		);
	}

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
		session('account', $data['account']);
		session('nickname', $data['nickname']);
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