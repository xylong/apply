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


	// 获取申请记录
	public function applyRecord()
	{
		if (IS_AJAX) {
			$type = I('get.type', 0);
			$p = I('get.p', 1);

			switch ($type) {
				case 1:
					$data = D('Borrow')->applyRecord($p);
					break;

				case 2:
					$data = D('Rent')->applyRecord($p);
					break;
				
				default:
					$data = D('Venue')->applyRecord($p);
					break;
			}

			exit(json_encode($data));
		}

		$uid = session('uid');
		$this->display('_index');
	}


}