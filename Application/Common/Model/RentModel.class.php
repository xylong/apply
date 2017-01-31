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


    /**
	 * 根据时间段获取申请
	 * @param  string $start 起始日期(如：2017-01-01)
	 * @param  string $end 截止日期(如：2017-01-01)
	 * @return array
	 */
	public function getApplyByTimes($start, $end)
	{
		$sql = "SELECT `id`,`uid`,`house`,`proposer`,`reason` `title`,`stime` `start`,`etime` `end` FROM `oa_rent` WHERE (stime >= '{$start}' AND stime < '{$end}') OR (stime < '{$start}' AND etime > '{$end}') OR (etime > '{$start}' AND etime <= '{$end}')";
		return $this->query($sql);
	}


    /**
     * 根据审核者获取申请
     * @param  boolean $is_examine  true／false [未审核／已审核]
     * @param  integer $p  页码
     * @return array
     */
    public function getApplyByUid($is_examine, $p)
    {
        // 获取对应角色的筛选条件
        $auth_id = session(C('USER_AUTH_KEY'));

        // 判断接收人
        $map['receiver'] = array('IN', $_SESSION['role_id']);

        // 已审核和未审核区分
        if ($is_examine) {
            $map['oa_approve.aid'] = array('NEQ' => NULL);
        }

        $count = $this->count();
        $Page = new \Think\Page($count, 10);
        $rows = $this->page($p, 10)
                    ->where($map)
                    ->join('LEFT JOIN __APPROVE__ ON __RENT__.id = __APPROVE__.aid')
                    ->field(array('id', 'code', 'house', 'proposer', 'apply_time'))
                    ->order('apply_time desc')->select();

        return array(
            'data' => $rows,
            'count' => $count
        );
    }


    public function detail($id)
    {
        $apply = $this->where(array('oa_rent.id' => $id))
                    ->field(array('id', 'code', 'uid', 'house', 'proposer', 'tutor', 'stime', 'reason', 'etime', 'apply_time'))
                    ->find();
        $result = M('Approve')->where(array('aid' => $id, 'type' => 2))->select();
        return array(
            'apply' => $apply,
            'result' => $result
        );
    }


}
