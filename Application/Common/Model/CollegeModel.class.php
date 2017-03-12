<?php
namespace Common\Model;
use Think\Model;
/**
 * 学院
 */
class CollegeModel extends Model
{
	protected $_validate = array(
		array('id', 'number', '', 2, '', 2),
		array('name', 'require', '学院或部门已存在', 1, 'unique', 3),
	);

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


	/**
	 * 获取学院的负责人
	 * @param  integer $id 学院id
	 * @return array
	 */
	public function getHeadByCid($id)
	{
		$uid = $this->where(array('id' => $id))->getField('uid');
		if ($uid) {
			return explode(',', $uid);
		}
		return array();
	}


	/**
	 * 为学院设置负责人
	 * @param array $uid 管理员id
	 * @param integer $id  学院id
	 */
	public function setHeadForCid($uid, $id)
	{
		$data = array(
			'uid' => implode(',', $uid),
			'id' => $id
		);
		return $this->save($data);
	}


}