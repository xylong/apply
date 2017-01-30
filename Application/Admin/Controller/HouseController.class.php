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
			$auth_id = session(C('USER_AUTH_KEY'));
			$data = $this->rent->getApplyByUid($auth_id, $is_examine);
			exit(json_encode($data));
		}
		var_dump($auth_id);
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
