<?php
namespace Common\Model;
use Think\Model;

class BorrowModel extends Model
{

	protected $_validate = array(
		array('theme', 'require', '活动主题必填', 1, '', 1),	// 主题
		array('phone', 'checkPhone', '手机格式错误', 1, 'function', 1),	// 手机号
		array('stime', 'require', '开始时间必选', 1),	// 开始时间
		array('etime', 'require', '结束时间必选', 2),	// 结束时间
		array('borrow', 'is_array', '借用详情必填', 1, 'function', 1),	// 申请数量
	);

	protected $_auto = array ( 
		array('code', 'apply_code', 1, 'function'),	// 申请码
		array('apply_time', 'getApplyTime', 1, 'function'),	// 申请时间
		array('uid', 'getApplicant', 1, 'function'),	// 申请者id
		array('borrow', 'get_apply_num', 1, 'callback'),
	);

	/**
	 * 组装租借数量
	 * @param  array $data 租借数量
	 * @return string
	 */
	public function get_apply_num($data)
	{
		foreach ($data as $index => $item) {
			if (!$item) {
				unset($data[$index]);
			}
		}
		return implode(',', $data);
	}

	/**
	 * 根据月份获取数据
	 * @param  string $map 月份(如：2017-01)
	 * @return array
	 */
	public function getApplyByMonth($map)
	{
		$sql = "SELECT id,theme title,DATE_FORMAT(stime,'%Y-%m-%d') start,DATE_FORMAT(etime,'%Y-%m-%d') end FROM oa_borrow WHERE DATE_FORMAT(stime,'%Y-%m') = DATE_FORMAT(NOW(), '{$map}')";
		return $this->query($sql);
	}


}
