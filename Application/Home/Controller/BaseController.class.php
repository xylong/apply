<?php
namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class BaseController extends Controller
{
	
	public function _initialize()
	{
		$permit_id = session(C('USER_AUTH_KEY'));
		if (!isset($permit_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
	}

}