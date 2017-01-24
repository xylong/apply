<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class GoodsController extends BaseController
{
	private $goods;

	public function _initialize()
	{
		$this->goods = D('Goods');
	}
	
	public function index()
	{
		if (IS_AJAX) {
			$pid = I('get.pid', 0);
			$data = $this->goods->getGoods($pid);
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	public function apply()
	{
		$this->display();
	}

	

}