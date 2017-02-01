<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 站场展架
*/
class VenueController extends BaseController
{
	
	public function _initialize()
	{
	}


	public function index()
	{
		$this->display('_index');
	}



}