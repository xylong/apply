<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 青春工坊申请
 */
class HouseController extends BaseController
{
	public function _initialize()
	{
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





}
