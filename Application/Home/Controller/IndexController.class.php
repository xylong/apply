<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->display('main');
    }


    public function borrow()
	{
		$this->display();
	}

	public function house()
	{
		$this->display();
	}

	public function square()
	{
		$this->display();
	}



}