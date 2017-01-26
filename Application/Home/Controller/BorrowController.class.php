<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 物资申请
 */
class BorrowController extends BaseController
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
    		$data = $this->borrow->getApplyByMonth('2017-01');
    		exit(json_encode($data));
    	}
        $this->display('_index');
    }

    public function apply()
	{
		if (IS_AJAX) {
			if (!$this->borrow->create()) {
                $this->error($this->borrow->getError());
            } else {
                if ($this->borrow->add()) {
                    returnJson(true, '申请提交成功');
                } else {
                    returnJson(false, '申请提交失败');
                }
            }
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
