<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends BaseController
{
	function _initialize() {
		$auth_id = session(C('USER_AUTH_KEY'));
		if (!isset($auth_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
	}
	
    public function index(){
        $this->display('Menu/index');
    }



}