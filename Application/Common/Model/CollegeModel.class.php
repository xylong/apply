<?php
namespace Common\Model;
use Think\Model;

class CollegeModel extends Model
{

	public function getColleges($p, $keyword)
	{
		if ($keyword) {
			$map = array('name' => array('LIKE', '%'.$keyword.'%'));
		}

		$Page = new \Think\Page($count, 10);
		$count = $this->where($map)->count();
		$rows = $this->page($p, 10)->where($map)->field(array('id', 'name', 'type', 'uid'))->order('id')->select();
		return array(
			'data' => $rows,
			'count' => $count
		);
	}



}