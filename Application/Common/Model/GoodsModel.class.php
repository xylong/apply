<?php
namespace Common\Model;
use Think\Model;

class GoodsModel extends Model
{

	/**
	 * 获取物品
	 * @param  integer $pid  物品分类id(如果没有pid就获取物品分类)
	 * @param  boolean $flag 如果为true就统计出所有分类的库存
	 * @return array
	 */
	public function getGoods($pid = 0, $flag = false)
	{
		// 返回分类下所有物品
		if ($pid) {
			$map = array(
				'pid' => array('EQ', $pid),
				'isdel' => 1
			);
			return $this->where($map)->field(array('id', 'number', 'status'))->order('id')->select();
		}
		// 统计全部分类的库存情况
		if ($flag) {
			$sql = 'SELECT a.id,a.`name`,COUNT(*) total, SUM(b.`status`) stock FROM oa_goods a INNER JOIN oa_goods b ON a.id = b.pid WHERE a.pid = 0 GROUP BY a.id';
			return $this->query($sql);
		}
		// 返回所有分类
		$data = $this->where(array('pid' => 0, 'isdel' => 1))->order('id asc')->field(array('id', 'name', 'classify'))->select();	
		return $data;
	}



}