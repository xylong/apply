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
		$this->assign('menu_action', 'index');
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


	public function qrcode()
	{
		if (IS_AJAX) {
			$id = I('get.id');
			$type = I('get.type');
			exit(__CONTROLLER__ . '/showQR/id/' . $id . '/type/' . $type);
		}
	}


	public function showQR($id, $type)
	{
		switch ($type) {
			case 1:
				$action = 'getBorrowById';
				break;

			case 2:
				$action = 'getHouseById';
				break;
			
			default:
				$action = 'getVenueById';
				break;
		}
		$info = 'http://' . $_SERVER["HTTP_HOST"] . '/index.php/Home/Public/'. $action . '?id=' . $id;
		qrcode($info);
	}


	// 下载二维码
	public function downloadQR($id, $type)
	{
		$map['id'] = array('EQ', $id);
		switch ($type) {
			case 1:
				$action = 'getBorrowById';
				$data = D('Borrow')->where($map)->getField('code');
				break;

			case 2:
				$action = 'getHouseById';
				$data = D('Rent')->where($map)->getField('code');
				break;
			
			default:
				$action = 'getVenueById';
				$data = D('Venue')->where($map)->getField('code');
				break;
		}
		$file = $data . '.png';
		$info = 'http://' . $_SERVER["HTTP_HOST"] . '/index.php/Home/Public/'. $action . '?id=' . $id;
		qrcode($info, $file);
		downloadFile($file);
	}


}
