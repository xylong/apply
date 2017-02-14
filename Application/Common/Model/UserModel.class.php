<?php
namespace Common\Model;
use Think\Model;

class UserModel extends Model
{
	protected $_validate = array(
		array('cid', 'number', ''),	// 学院id
		array('type', array(1,2,3), '值的范围不正确！', 2, 'in'),
		array('phone', 'checkPhone', '手机格式错误', 1, 'function'),	// 手机号
	);

	protected $_auto = array ( 
         array('password','md5', 3, 'function'),
         array('account', 'generateAccount', 1, 'callback')
     );

	// 生成账号
	public function generateAccount()
	{
		for ($i=0; $i < 10; $i++) { 
			$account[] = rand(100000, 999999);
		}
		foreach ($account as $item) {
			if (!$this->where(array('account' => $item))->getField('id')) {
				return $item;
				break;
			}
		}
	}

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
			$map['oa_user.account'] = array('EQ', $keyword);
		} else if (checkPhone($keyword)) {
			$map['oa_user.phone'] = array('EQ', $keyword);
		} else {
			$map = array('oa_user.type' => $type);
		}
		$map['status'] = array('EQ', 1);

		$Page = new \Think\Page($count, 10);
		$count = $this->where($map)->count();
		$rows = $this->page($p, 10)->join('LEFT JOIN __COLLEGE__ ON __USER__.cid = __COLLEGE__.id')->where($map)->field('oa_user.id,account,phone,oa_college.name nickname')->order('id')->select();

		return array(
			'data' => $rows,
			'count' => $count
		);
	}


	/**
	 * 用户详情
	 * @param  integer $id 用户id
	 * @return array
	 */
	public function getuserInfo($id)
	{
		$map = array(
			'oa_user.id' => $id,
			'oa_user.status' => 1
		);
		$field = array('oa_user.id', 'oa_user.account', 'oa_user.type', 'oa_user.phone', 'oa_user.cid', 'oa_user.society', 'oa_user.last_login_time', 'oa_college.name college');
		return $this->join('LEFT JOIN __COLLEGE__ ON __USER__.cid = __COLLEGE__.id')->where($map)->field($field)->find();
	}


	public function doLogin($data)
	{
		$password = md5($data['password']);
		$map1 = array('oa_user.account' => $data['username'], 'oa_user.password' => $password, 'oa_user.status' => 1);
		$map2 = array('oa_user.username' => $data['username'], 'oa_user.password' => $password, 'oa_user.status' => 1);
		$field = array('oa_user.id,account,last_login_time,society,oa_college.name college');

		if ($user_info = $this->join('LEFT JOIN __COLLEGE__ ON __USER__.cid = __COLLEGE__.id')->field($field)->where($map1)->find()) {
			$this->setAuthInfo($user_info);
		} elseif ($user_info = $this->join('LEFT JOIN __COLLEGE__ ON __USER__.cid = __COLLEGE__.id')->field($field)->where($map2)->find()) {
			$this->setAuthInfo($user_info);
		} else {
			return false;
		}
	}


	private function setAuthInfo($data)
	{
		session(C('USER_AUTH_KEY'), $data['id']);
		session('account', $data['account']);
		session('nickname', $data['college']);
		if ($data['society']) {
			session('society', $data['society']);
		}

		$time = time();
		$_data = array(
			'id' => $data['id'],
			'last_login_time' => date('Y-m-d H:i:s', time())
		);
		$this->save($_data);
		return true;
	}

}