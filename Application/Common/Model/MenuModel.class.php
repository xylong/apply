<?php
namespace Common\Model;
use Think\Model;
/**
 * 菜单
 */
class  MenuModel extends Model
{
	protected $_validate = array(
		array('url','require','url必须填写'), //默认情况下用正则进行验证
	);


	public function menu()
	{
	 	$data = $this->field('id, title, pid, url')->select();
	 	return arrayPidProcess($data);
	}

	
}
?>