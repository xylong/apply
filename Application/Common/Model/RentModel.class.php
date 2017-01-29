<?php
namespace Common\Model;
use Think\Model;
/**
 * 青春工坊申请
 */
class RentModel extends Model
{

    protected $_validate = array(
        array('house', 'require', '请选择青春工坊', 1),
        array('proposer', 'require', '申请人不能为空', 1),
        array('phone', 'checkPhone', '手机格式错误', 1, 'function'),
        array('tutor', 'require', '指导老师不能为空', 1),
        array('reason', 'require', '', 2),
        array('stime', 'require', '开始时间不能为空', 1),	// 开始时间
        array('etime', 'require', '结束时间不能为空', 1)	// 结束时间
	);

    protected $_auto = array (
		array('code', 'apply_code', 1, 'function'),	// 申请码
		array('apply_time', 'getApplyTime', 1, 'function'),	// 申请时间
		array('uid', 'getApplicant', 1, 'function')	// 申请者id
	);


}
