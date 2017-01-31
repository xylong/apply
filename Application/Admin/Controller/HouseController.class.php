<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 青春工坊
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

	// 青春工坊管理
	public function index()
	{
		if (IS_AJAX) {
			$data = $this->house->getHouse();
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	// 青春工坊申请
	public function apply()
	{
		if (IS_AJAX) {
			$is_examine = I('get.is_examine', 0);
			$p = I('get.p', 1);
			$data = $this->rent->getApplyByUid($is_examine, $p);
			exit(json_encode($data));
		}
		$this->display();
	}


	// 申请详情
	public function applyDetail()
	{
		if (IS_AJAX) {
			$id = I('get.id', 0);
			$data = $this->rent->detail($id);
			exit(json_encode($data));
		}
	}


	// 提交审核结果
	public function review()
	{
		if (IS_AJAX) {
			$data = I('post.');
			if ($this->rent->audit($data)) {
				returnJson(true, '审核成功');
			} else {
				returnJson(true, '审核成功');
			}
		}
	}


	// 编辑青春工坊
    public function edit()
    {
        if (IS_AJAX) {
            if (!$this->house->create()) {
                $this->error($this->house->getError());
            } else {
                if ($this->house->id) {
                    $handle = $this->house->save();
                } else {
                    unset($this->house->id);
                    $handle = $this->house->add();
                }
                if ($handle) {
                    returnJson(true, '申请提交成功');
                } else {
                    returnJson(false, '申请提交失败');
                }
            }
        }
    }



}
