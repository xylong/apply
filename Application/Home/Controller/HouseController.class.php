<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 青春工坊申请
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


	function getHouse()
	{
		if (IS_AJAX) {
			$data = $this->house->getHouse();
			exit(json_encode($data));
		}
	}



}
