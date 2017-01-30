<?php
namespace Common\Model;
use Think\Model;
/**
 * 角色
 */
class RoleModel extends Model
{
	protected $_validate = array(
		array('id', 'number', '', 2, '', 2),
		array('name', 'require', '角色名称必须', 1),
		array('remark', 'require', '', 2),
	);

	public function getRole($id = null)
	{
		return $this->select();
	}


	/**
	 * 分配权限
	 * @param  array $role_id 角色数组
	 * @param  integer $uid     用户id
	 * @return boolean
	 */
	public function assignAuth($role_id, $uid)
	{
		$model = M('RoleUser');
		$model->where(array('user_id' => $uid))->delete();

		$data = array();
		foreach ($role_id as $index => $item) {
			array_push($data, array(
				'role_id' => $item,
				'user_id' => $uid
			));
		}

		return $model->addAll($data);
	}


	/**
	 * 获取权限
	 * @param  integer $user_id 用户id
	 * @return array
	 */
	public function permission($user_id)
	{
		$model = M('RoleUser');
		return $model->where(array('user_id' => $user_id))->getField('role_id', true);
	}

}
