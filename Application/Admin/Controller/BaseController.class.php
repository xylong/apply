<?php
namespace Admin\Controller;
use Think\Controller;
/**
*
*/
class BaseController extends Controller
{
	function _initialize() {
		$auth_id = session(C('USER_AUTH_KEY'));
		if (!isset($auth_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
		// $this -> _assign_menu();
		// $this -> _assign_badge_count();
		// $this->_system_log();
	}

}
