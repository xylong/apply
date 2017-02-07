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
		// 获取所有分类及库存
		if ($flag) {
			return $this->inventory();
		}

		// 返回分类下所有物品及库存
		if ($pid) {
			$map = array(
				'pid' => array('EQ', $pid),
				'isdel' => 1
			);
			$goods = $this->where($map)->field(array('id', 'number', 'status'))->order('id')->select();
			$stock = $this->inventory($pid);
			return array(
				'goods' => $goods,
				'stock' => $stock
			);
		}

		// 返回所有分类
		$data = $this->where(array('pid' => 0, 'isdel' => 1))->order('id asc')->field(array('id', 'name', 'classify'))->select();
		return $data;
	}

	/**
	 * 库存
	 * @param  integer $pid 分类id
	 * @return array
	 */
	private function inventory($pid = 0)
	{
		if ($pid) {
			$map = 'WHERE a.id = ' . $pid;
		}
		$sql = 'SELECT a.id,a.`name`,COUNT(*) stock, SUM(b.`status`) occupy FROM oa_goods a INNER JOIN oa_goods b ON a.id = b.pid ' . $map . ' GROUP BY a.id';
		return $this->query($sql);
	}


	/**
	 * 根据需求编号生成具体需求
	 * @param  array $need 需求编号
	 * @return [type]       [description]
	 */
	public function getNeed($need)
	{
		$classify = $this->where(array('pid' => 0, 'isdel' => 1))->getField('id, name');
		foreach ($need as $key => $value) {
            $arr = explode('_', $value);
            $data[$key]['id'] = $arr[0];
            $data[$key]['name'] = $classify[$arr[0]];
            $data[$key]['number'] = $arr[1];
        }
        return $data;
	}


	/**
	 * 提供设备选择
	 * @param  string $mid 申请借用的物资类型
	 * @return array      具体物资
	 */
	public function provideSelection($arr)
	{
		$data = $this->where(array('status' => 0))->select();
		return node_merge($data, $arr);
	}


	/**
	 * 更改物品的占用状态
	 * @param  integer $id 申请id
	 * @param  array $good 物品id
	 * @param  string $data   物品id
	 */
	public function occupyStatus($id, $goods)
	{
		$equipment = '';
		foreach ($goods as $index => $item) {
			$this->where(array('id' => $item))->save(array('status' => 1));
			$equipment .= $item . ',';
		}
		$equipment = substr($equipment, 0, -1);
		$lend_time = date('Y-m-d H:i:s', time());
		return D('Borrow')->where(array('id' => $id))->save(array('goods' => $equipment, 'lend_time' => $lend_time));
	}


	/** 获取申请借到的设备
	 * @param  string $str 借的设备id，逗号连接
	 * @param  array $arr 借的设备的分类id
	 * @return       [description]
	 */
	public function getRent($str, $arr)
	{
		foreach ($arr as $key => $value) {
			$brr[] = $value['id'];
		}

		$sql = 'SELECT * FROM oa_goods WHERE pid = 0 AND `status` = 0 UNION SELECT * FROM oa_goods WHERE id IN('. $str .')';
		$data = $this->query($sql);
		return node_merge($data, $brr);
	}



}
