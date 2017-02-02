<?php
namespace Common\Model;
use Think\Model;
/**
 * 展场展架
 */
class VenueModel extends Model
{
    const UPLOAD_DIR = './Public/Upload/';
    const APPLY_TYPE = 3;   // 申请类型

    protected $_validate = array(
        array('theme', 'require', '活动主题不能为空', 1),   // 活动主题
        array('proposer', 'require', '申请人不能为空', 1), // 申请人
        array('phone', 'checkPhone', '手机格式错误', 1, 'function'),  // 手机号
        array('num', 'number', '展架数量必填', 1),    // 展架数量
        array('place', 'require', '摆放地点必填', 1), // 摆放地点
        array('remark', 'require', '', 2),  // 备注
        array('stime', 'require', '开始时间不能为空', 1),   // 开始时间
        array('etime', 'require', '结束时间不能为空', 2, ),	// 结束时间
	);

    protected $_auto = array (
		array('code', 'apply_code', 1, 'function'),	// 申请码
		array('apply_time', 'getApplyTime', 1, 'function'),	// 申请时间
        array('uid', 'getApplicant', 1, 'function'), // 申请者id
        array('img', 'saveImg', 1, 'callback'), // 活动海报
        // array('planning', 'savePlan', 1, 'callback'),    // 活动策划
        array('utype', 'getUserType', 1, 'callback'),   // 申请者类型即申请类型
		array('receiver', 'initReceiver', 1, 'callback')	// 接受者角色
	);


    // 初始化接收角色
    public function initReceiver()
    {
        $step = C('STEP');
        $utype = $this->getUserType();
        return $utype == 3 ? $step[2][2][0] : $step[2][0][0];
    }


    // 用户类型(申请类型)
    public function getUserType()
    {
        $uid = getApplicant();
        return M('User')->where(array('id' => $uid))->getField('type');
    }


    // 上传图片
    public function saveImg()
    {
        $images = $_POST['images'];
        $dir = mk_dir(self::UPLOAD_DIR);
        
        $str = '';
        foreach ($images as $index => $img) {
            $start=strpos($img,',');
            $img= substr($img,$start+1);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $fileName = uniqid() . '.jpg';
            $saveName = self::UPLOAD_DIR . $dir . $fileName;

            $success = file_put_contents($saveName, $data);
            $str .= ',' . $dir . $fileName;
        }
        return ltrim(rtrim($str, ','), ',');
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
            $map['oa_approve.aid'] = array('EXP','IS NULL');    // 未审核条件
            $map['receiver'] = array('IN', $_SESSION['role_id']);   // 接收人条件

            $count = $this->where($map)->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid AND __APPROVE__.type = ".self::APPLY_TYPE." AND __APPROVE__.uid = {$_SESSION["auth_id"]}")->count();
            $Page = new \Think\Page($count, 10);
            $rows = $this->page($p, 10)
                        ->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid AND __APPROVE__.type = ".self::APPLY_TYPE." AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->field(array('id', 'code', 'theme', 'apply_time'))
                        ->order('apply_time desc')->select();
        } else {
            $map['oa_audit_log.apply_type'] = 1;    // 申请类型条件
            $map['oa_approve.uid'] = $_SESSION['auth_id'];  // 自己的审核结果条件
            $map['oa_audit_log.uid'] = $_SESSION['auth_id'];    // 自己的审核记录条件

            $count = $this->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid  AND __APPROVE__.type = ".self::APPLY_TYPE."  AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->join('LEFT JOIN __AUDIT_LOG__ ON __VENUE__.id = __AUDIT_LOG__.apply_id')
                        ->count();
            $Page = new \Think\Page($count, 10);
            $rows = $this->page($p, 10)
                        ->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid AND __APPROVE__.type = ".self::APPLY_TYPE."  AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->join('LEFT JOIN __AUDIT_LOG__ ON __VENUE__.id = __AUDIT_LOG__.apply_id')
                        ->field(array('oa_venue.id', 'oa_venue.code', 'oa_venue.theme', 'oa_approve.time apply_time'))
                        ->order('time desc')->select();
        }

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
        $apply = $this->where(array('oa_venue.id' => $id))
                    ->field(array('id', 'code', 'uid', 'theme', 'phone', 'proposer', 'num', 'place', 'img', 'planning', 'remark', 'utype', 'stime', 'etime', 'apply_time', 'receiver'))
                    ->find();
        $result = M('Approve')->join('LEFT JOIN __ADMIN__ ON __APPROVE__.uid = __ADMIN__.id')
                            ->join('LEFT JOIN __ROLE__ ON __APPROVE__.role_id = __ROLE__.id')
                            ->where(array('oa_approve.aid' => $id, 'oa_approve.type' => self::APPLY_TYPE))
                            ->field('oa_approve.*,oa_admin.account,oa_role.name role_name')
                            ->select();

        // 检查自己是否审核
        $myturn = true;
        foreach ($result as $index => $item) {
            if ($item['uid'] == $_SESSION['auth_id'] || $item['isagree'] == 2) {
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



}
