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
    		$start = I('get.start');
    		$end = I('get.end');
    		$data = $this->borrow->getApplyByTimes($start, $end);
    		foreach ($data as $index => $item) {
    			if ($item['end'] != '0000-00-00 00:00:00') {
	    			$data[$index]['end'] = substr($item['end'], 0, 8) . (substr($item['end'], 8, 2) + 1);
    			}
    			// 区分自己的申请
    			if (session(C('USER_AUTH_KEY')) == $item['uid']) {
    				$data[$index]['color'] = '#52d1e3';
    				$data[$index]['viewable'] = true;
    			} else {
    				$data[$index]['viewable'] = false;
    			}
    		}
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

	public function getApply()
	{
		if (IS_AJAX) {
			$id = I('get.id', 0);
			$data = $this->borrow->getApplyById($id);
			exit(json_encode($data));
		}
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
