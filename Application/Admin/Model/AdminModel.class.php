<?php
namespace Admin\Model;
use Think\Model;

class AdminModel extends Model
{

	protected $_validate = array(
		array('account', 'require', '用户名已存在', 1, 'unique', 3),
		array('phone','/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/','手机号码错误！',2,'regex',1),
		array('phone','','手机号码已存在！', 2, 'unique', 1),
		array('id_number','','一卡通号码已存在', 2, 'unique', 1),
		array('repassword', 'password', '确认密码不正确', 1, 'confirm', 1),
		array('password', 'checkPwd', '密码不能小于6位', 1, 'function', 1)
	);

	protected $_auto = array (
		array('status','1'),
		array('password', 'md5', 3, 'function'),
	);


	/**
	 * 用户列表
	 * @param  integer $p  页码
	 * @return array       分页数据和总页数
	 */
	public function getUsers($p, $keyword)
	{
		$map = array('status' => 1);
		if ($keyword) {
			$map['account'] = array('LIKE', '%'.$keyword.'%');
		}

		$count = $this->where($map)->count();
		$Page = new \Think\Page($count, 10);
		$rows = $this->page($p, 10)->where($map)->field(array('id','account','id_number','phone'))->order('id')->select();
		
		return array(
			'data' => $rows,
			'count' => $count
		);
	}


	/**
	 * 后台登录
	 * @param  array $data     登录信息
	 * @return array
	 */
	public function doLogin($data)
	{
		$password = md5($data['pwd']);

		$map1 = array('account' => $data['account'], 'password' => $password, 'status' => 1);
		$map2 = array('id_number' => $data['account'], 'password' => $password, 'status' => 1);

		if ($auth_info = $this->where($map1)->find()) {
			return $this->setAuthInfo($auth_info);
		} elseif ($auth_info = $this->where($map2)->find()) {
			return $this->setAuthInfo($auth_info);
		} else {
			return false;
		}
	}

	// 设置身份信息
	private function setAuthInfo($data)
	{
		if ($data['account'] === 'admin') {
			session(C('ADMIN_AUTH_KEY'), true);
		}
		session(C('USER_AUTH_KEY'), $data['id']);
		session('admin_name', $data['account']);

		$time = time();
		$_data = array(
			'id' => $data['id'],
			'last_login_time' => date('Y-m-d H:i:s', time())
		);
		$this->save($_data);
		return true;
	}

}
