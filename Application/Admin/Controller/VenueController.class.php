<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 站场展架
*/
class VenueController extends BaseController
{
	private $venue;
	
	public function _initialize()
	{
		$this->venue = D('Venue');
	}


	public function index()
	{
		if (IS_AJAX) {
			$is_examine = I('get.is_examine', 0);
			$p = I('get.p', 1);
			$data = $this->venue->getApplyByUid($is_examine, $p);
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	public function applyDetail()
	{
		if (IS_AJAX) {
			$id = I('get.id', 0);
			$data = $this->venue->getApplyById($id);

			$url = array();
			$config = C('TMPL_PARSE_STRING');
			$imgs = explode(',', $data['apply']['img']);
			foreach ($imgs as $img) {
				$url[] = $config['__UPLOAD__'] . $img;
			}
			$data['apply']['img'] = implode(',', $url);

			exit(json_encode($data));
		}
	}



}