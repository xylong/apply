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
		echo json_encode($post);
	}

}