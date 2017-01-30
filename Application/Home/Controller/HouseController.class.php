<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 青春工坊申请
 */
class HouseController extends BaseController
{
	private $house;
	private $rent;

	public function _initialize()
	{
		$this->house = D('House');
		$this->rent = D('Rent');
	}

    public function index()
    {
		if (IS_AJAX) {
			$start = I('get.start');
    		$end = I('get.end');
			$data = $this->rent->getApplyByTimes($start, $end);
			exit(json_encode($data));
		}
        $this->display('_index');
    }


    public function apply()
	{
		if (IS_AJAX) {
			if (!$this->rent->create()) {
				$this->error($this->rent->getError());
			} else {
				if ($this->rent->add()) {
					returnJson(true, '申请提交成功');
				} else {
					returnJson(false, '申请提交失败');
				}
			}
		}
		$this->display();
	}


	function getHouse()
	{
		if (IS_AJAX) {
			$data = $this->house->getHouse();
			exit(json_encode($data));
		}
	}



}
