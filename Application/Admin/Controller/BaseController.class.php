<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class BaseController extends Controller
{
	public function _initialize()
	{
		$this->_assign_menu();
	}
	
	public function _assign_menu()
	{
	}

}