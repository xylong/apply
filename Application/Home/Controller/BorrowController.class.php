<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 物资申请
 */
class BorrowController extends BaseController
{
	private $goods;

	public function _initialize()
	{
		$this->goods = D('Goods');
	}

    public function index()
    {
        $this->display('_index');
    }

    public function apply()
	{
		if (IS_AJAX) {
			$post = I('post.');
			exit(json_encode($post));
		}
		$this->display();
	}

	public function getGoods()
	{
		if (IS_AJAX) {
			$pid = I('get.pid', 0);
			$data = $this->goods->getGoods($pid, true);
			exit(json_encode($data));
		}
	}



}
