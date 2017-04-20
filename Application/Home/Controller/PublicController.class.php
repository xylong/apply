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
		header('Location: ' . U("Base/applyRecord"));
	}

	// 登出
	public function logout() {
		$auth_id = session(C('USER_AUTH_KEY'));
		if (isset($auth_id)) {
			session(C('USER_AUTH_KEY'), null);
			session('nickname', null);
			session('society', null);
			session('utype', null);
			session_destroy();

			redirect(U(C('USER_AUTH_GATEWAY')));
		} else {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
	}

	/*物资借用详情页*/
	public function getBorrowById($id)
	{
		$data = D('Borrow')->getApplyById($id);
		$this->assign('data', $data);
		$this->display('apply_borrow');
	}

	/*青春工坊借用详情页*/
	public function getHouseById($id)
	{
		$data = D('Rent')->detail($id);
		$this->assign('data', $data);
		$this->display('apply_house');
	}

	/*展架展场借用详情页*/
	public function getVenueById($id)
	{
		$config = C('TMPL_PARSE_STRING');
		$data = D('Venue')->getApplyById($id);
		$imgs = explode(',', $data['apply']['img']);
		foreach ($imgs as $img) {
			$src[] = $config['__UPLOAD__'] . $img;
		}
		$data['apply']['img'] = $src;

		switch ($data['apply']['place']) {
			case 1:
				$data['apply']['place'] = '青广左侧';
				break;

			case 2:
				$data['apply']['place'] = '青广中部';
				break;
			
			default:
				$data['apply']['place'] = '青广右侧';
				break;
		}

		$this->assign('data', $data);
		$this->display('apply_venue');
	}


	public function demo()
	{
		$this->display('demo');
	}


}