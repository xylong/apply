<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends BaseController
{
    public function index()
    {
        $this->display('_index');
    }

    public function borrow()
	{
		$this->display();
	}

	public function borrow_list()
	{
		$this->display();
	}

	public function house()
	{
		$this->display();
	}

	public function house_list()
	{
		$this->display();
	}

	public function square()
	{
		$this->display();
	}

	public function square_list()
	{
		$this->display();
	}



}