<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class GoodsController extends BaseController
{
	private $goods;
	private $borrow;

	public function _initialize()
	{
		$this->goods = D('Goods');
		$this->borrow = D('Borrow');
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
		if (IS_AJAX) {
			$is_examine = I('get.is_examine', 0);
			$p = I('get.p', 1);
			$data = $this->borrow->getApplyByUid($is_examine, $p);
			exit(json_encode($data));
		}
		$this->display();
	}


	// 申请详情
	public function applyDetail()
	{
		if (IS_AJAX) {
			$id = I('get.id', 0);
			$data = $this->borrow->getApplyById($id);
			exit(json_encode($data));
		}
	}


	// 提交审核结果
	public function review()
	{
		if (IS_AJAX) {
			$data = I('post.');
			if ($this->borrow->audit($data)) {
				returnJson(true, '审核成功');
			} else {
				returnJson(true, '审核成功');
			}
		}
	}

	

}