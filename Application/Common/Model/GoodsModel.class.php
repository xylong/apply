<?php
namespace Common\Model;
use Think\Model;

class GoodsModel extends Model
{

	public function getGoods($pid = 0)
	{
		if ($pid) {
			$map = array(
				'pid' => array('EQ', $pid),
				'isdel' => 1
			);
			return $this->where($map)->field(array('id', 'number', 'status'))->order('id')->select();
		}
		$data = $this->where(array('pid' => 0, 'isdel' => 1))->order('id asc')->field(array('id', 'name', 'classify'))->select();	
		return $data;
	}



}