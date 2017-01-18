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

	

}