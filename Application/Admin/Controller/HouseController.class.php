<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 青春工坊
*/
class HouseController extends BaseController
{
	private $house;

	public function _initialize()
	{
		$this->house = D('House');
	}

	public function index()
	{
		if (IS_AJAX) {
			$data = $this->house->getHouse();
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	public function apply()
	{
		$this->display();
	}


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
