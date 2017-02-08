<?php
namespace Common\Model;
use Think\Model;

class BorrowModel extends Model
{
	public $apply_type = 0;

	protected $_validate = array(
		array('theme', 'require', '活动主题必填', 1, '', 1),	// 主题
		array('phone', 'checkPhone', '手机格式错误', 1, 'function', 1),	// 手机号
        array('stime', 'require', '开始时间必选', 1), // 开始时间
		array('borrow', 'is_array', '借用详情必填', 1, 'function', 1),	// 申请数量
	);

	protected $_auto = array ( 
		array('code', 'apply_code', 1, 'function'),	// 申请码
		array('apply_time', 'getApplyTime', 1, 'function'),	// 申请时间
		array('uid', 'getApplicant', 1, 'function'),	// 申请者id
		array('borrow', 'get_apply_num', 1, 'callback'),
		array('receiver', 'initReceiver', 1, 'callback')	// 接受者角色
	);

	public function initReceiver()
    {
        $step = C('STEP');
        return $step[$this->apply_type][0];
    }

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
	 * 根据时间段获取数据
	 * @param  string $start 起始日期(如：2017-01-01)
	 * @param  string $end 截止日期(如：2017-01-01)
	 * @return array
	 */
	public function getApplyByTimes($start, $end, $flag = false)
	{
		// $sql = "SELECT id,uid,theme title,DATE_FORMAT(stime,'%Y-%m-%d') `start`,DATE_FORMAT(etime,'%Y-%m-%d') `end` FROM oa_borrow WHERE (stime >= '{$start}' AND stime < '{$end}') OR (stime < '{$start}' AND etime > '{$end}') OR (etime > '{$start}' AND etime <= '{$end}')";
        
        if ($flag) {
            $sql = "SELECT `code`,`account`,`theme`,oa_borrow.`phone`,`stime`,`etime`,`apply_time` FROM `oa_borrow` LEFT JOIN oa_user ON oa_user.id = oa_borrow.uid WHERE apply_time BETWEEN '{$start}' AND '{$end}'";
        } else {
            $sql = "SELECT `id`,`uid`,`theme` `title`,`stime` `start`,`etime` `end` FROM `oa_borrow` WHERE uid = {$_SESSION['uid']} AND etime >= '{$start}' AND stime <= '{$end}'";
        }
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
        // 已审核和未审核区分
        if (!$is_examine) {
        	$map['oa_approve.aid'] = array('EXP','IS NULL');	// 未审核条件
        	$map['receiver'] = array('IN', $_SESSION['role_id']);	// 接收人条件

            $count = $this->where($map)->join("LEFT JOIN __APPROVE__ ON __BORROW__.id = __APPROVE__.aid AND __APPROVE__.type = 1 AND __APPROVE__.uid = {$_SESSION["auth_id"]}")->count();
            $Page = new \Think\Page($count, 10);
            $rows = $this->page($p, 10)
                        ->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __BORROW__.id = __APPROVE__.aid AND __APPROVE__.type = 1 AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->field(array('id', 'code', 'theme', 'goods', 'apply_time', 'lend_time', 'return_time'))
                        ->order('apply_time desc')->select();
        } else {
            $map['oa_audit_log.apply_type'] = 1;	// 申请类型条件
            $map['oa_approve.uid'] = $_SESSION['auth_id'];	// 自己的审核结果条件
            $map['oa_audit_log.uid'] = $_SESSION['auth_id'];	// 自己的审核记录条件

            $count = $this->where($map)
            			->join("LEFT JOIN __APPROVE__ ON __BORROW__.id = __APPROVE__.aid  AND __APPROVE__.type = 1  AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->join('LEFT JOIN __AUDIT_LOG__ ON __BORROW__.id = __AUDIT_LOG__.apply_id')
                        ->count();
            $Page = new \Think\Page($count, 10);
            $rows = $this->page($p, 10)
                        ->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __BORROW__.id = __APPROVE__.aid AND __APPROVE__.type = 1  AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->join('LEFT JOIN __AUDIT_LOG__ ON __BORROW__.id = __AUDIT_LOG__.apply_id')
                        ->field(array('oa_borrow.id', 'oa_borrow.code', 'oa_borrow.theme', 'oa_borrow.goods', 'oa_borrow.lend_time', 'oa_borrow.return_time', 'oa_approve.time apply_time'))
                        ->order('time desc')->select();
        }

        return array(
            'data' => $rows,
            'count' => $count
        );
    }


    /**
     * 根据申请者获取申请
     * @param  integer $p 页码
     * @return array
     */
    public function applyRecord($p)
    {
        $map['uid'] = session('uid');
        $count = $this->where($map)->count();
        $Page = new \Think\Page($count, 10);
        $rows = $this->page($p, 10)->where($map)->order('apply_time desc')->select();
        
        return array(
            'data' => $rows,
            'count' => $count
        );
    }


    /**
     * 审核详情
     * @param  integer $id 申请id
     * @return array     申请详情和审核结果
     */
	public function getApplyById($id)
	{
		$apply = $this->where(array('oa_borrow.id' => $id))
                    ->field(array('id', 'code', 'uid', 'theme', 'phone', 'borrow', 'goods', 'other', 'stime', 'etime', 'apply_time', 'lend_time', 'return_time', 'receiver'))
                    ->find();
        $result = M('Approve')->join('LEFT JOIN __ADMIN__ ON __APPROVE__.uid = __ADMIN__.id')
                            ->join('LEFT JOIN __ROLE__ ON __APPROVE__.role_id = __ROLE__.id')
                            ->where(array('oa_approve.aid' => $id, 'oa_approve.type' => 1))
                            ->field('oa_approve.*,oa_admin.account,oa_role.name role_name')
                            ->select();

        $need = explode(',', $apply['borrow']);
        $model = D('Goods');
        $apply['borrow'] = $model->getNeed($need);
        if ($apply['goods']) {
            $apply['goods'] = $model->getRent($apply['goods'], $apply['borrow']);
        }
        

        // 检查自己是否审核
        $myturn = true;
        foreach ($result as $index => $item) {
        	if ($item['uid'] == $_SESSION['auth_id'] || in_array($item['role_id'], $_SESSION['role_id']) || $item['isagree'] == 2) {
        		$myturn = false;
        		break;
        	}
        }
        return array(
            'apply' => $apply,
            'result' => $result,
            'myturn' => $myturn
        );
	}


	public function audit($data)
    {
        $data['type'] = 1;
        $data['uid'] = session('auth_id');
        $data['time'] = date('Y-m-d H:i:s', time());

        // 判断是否被同角色人员审核
        $map['id'] = array('EQ', $data['aid']);
        $map['role_id'] = array('IN', $_SESSION['role_id']);
        if ($this->where($map)->join('LEFT JOIN __APPROVE__ ON __BORROW__.id = __APPROVE__.aid')->find()) {
            return false;
        }

        // 审核结果入库
        if (M('Approve')->add($data)) {
        	$uid = session('auth_id');
            $handle = M('AuditLog')->add(array('apply_id' => $data['aid'], 'uid' => $uid, 'apply_type' => 1)); // 添加到审核日志

            // 如果同意就将审核往下一环节转发
            if ($data['isagree'] == 2) {
            	return $handle;
            }

            $step = C('STEP');
            $new_receiver = $step[0][1];
            return $this->save(array('id' => $data['aid'], 'receiver' => $new_receiver));
        }
        return false;
    }

}
