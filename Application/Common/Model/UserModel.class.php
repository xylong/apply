<?php
namespace Common\Model;
use Think\Model;

class UserModel extends Model
{

	/**
	 * 用户列表
	 * @param  integer $type 用户类型
	 * @param  integer $p  页码  
	 * @param  string $p  搜索关键字
	 * @return array       分页数据和总页数
	 */
	public function getUsers($type, $p, $keyword)
	{
		if (checkAccount($keyword)) {
			$map['account'] = array('EQ', $keyword);
		} else if (checkPhone($keyword)) {
			$map['phone'] = array('EQ', $keyword);
		} else if ($keyword) {
			$map['nickname'] = array('LIKE', '%'.$keyword.'%');
		} else {
			$map = array('type' => $type);
		}
		
		$Page = new \Think\Page($count, 10);
		$count = $this->where($map)->count();
		$rows = $this->page($p, 10)->where($map)->field(array('id', 'account', 'cid', 'nickname', 'phone'))->order('id')->select();

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