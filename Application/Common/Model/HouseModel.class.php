<?php
namespace Common\Model;
use Think\Model;
/**
 * 青春工坊
 */
class HouseModel extends Model
{

    protected $_validate = array(
		array('id', 'number', '', 2, '', 2),
		array('name', 'require', '青春工坊名字必须', 1),
		array('describe', 'require', '', 2, '', 1),
	);

    public function getHouse()
    {
        return $this->select();
    }

}
