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
        array('planning', 'savePlan', 1, 'callback'),    // 活动策划
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
     * 上传文件
     * @return string 文件路径
     */
    public function savePlan()
    {
        $file = $_POST['planning'];
        $file = preg_replace('/data:.*;base64,/i', '', $file);
        $data = base64_decode($file);

        $dir = mk_dir(self::UPLOAD_DIR);
        $fileName = uniqid() . '.zip';
        $saveName = self::UPLOAD_DIR . $dir . $fileName;

        $success = file_put_contents($saveName, $data);
        return $dir . $fileName;
    }


    /**
     * 根据时间段获取数据
     * @param  string $start 起始日期(如：2017-01-01)
     * @param  string $end 截止日期(如：2017-01-01)
     * @return array
     */
    public function getApplyByTimes($start, $end)
    {
        // $sql = "SELECT id,uid,theme title,DATE_FORMAT(stime,'%Y-%m-%d') `start`,DATE_FORMAT(etime,'%Y-%m-%d') `end` FROM oa_venue WHERE (stime >= '{$start}' AND stime < '{$end}') OR (stime < '{$start}' AND etime > '{$end}') OR (etime > '{$start}' AND etime <= '{$end}')";
        $sql = "SELECT `id`,`theme` `title`,`stime` `start`,`etime` `end` FROM `oa_venue` WHERE uid = {$_SESSION['uid']} AND etime >= '{$start}' AND stime <= '{$end}'";
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
        // 如果是学院党委团委或者校团委指导老师就存在一一对应的审核关系
        foreach ($_SESSION['role_id'] as $rid) {
            if (in_array($rid, array(2, 3, 4))) {
                $map['_string'] = 'FIND_IN_SET('.$_SESSION['auth_id'].',oa_college.uid)';   // 筛选出属于自己管理的学院的申请
            }
        }

        // 已审核和未审核区分
        if (!$is_examine) {
            $map['oa_approve.aid'] = array('EXP','IS NULL');    // 未审核条件
            $map['receiver'] = array('IN', $_SESSION['role_id']);   // 接收人条件

            $count = $this->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid AND __APPROVE__.type = ".self::APPLY_TYPE." AND __APPROVE__.uid = {$_SESSION["auth_id"]}")
                        ->join('LEFT JOIN oa_user ON oa_venue.uid = oa_user.id')    // 得到申请者所属学院
                        ->join('LEFT JOIN oa_college ON oa_user.cid = oa_college.id')    // 得到学院管理者
                        ->count();
            $Page = new \Think\Page($count, 10);
            $rows = $this->page($p, 10)
                        ->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid AND __APPROVE__.type = ".self::APPLY_TYPE." AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->join('LEFT JOIN oa_user ON oa_venue.uid = oa_user.id')
                        ->join('LEFT JOIN oa_college ON oa_user.cid = oa_college.id')
                        ->field(array('oa_venue.id', 'code', 'theme', 'apply_time'))
                        ->order('apply_time desc')->select();
        } else {
            $map['oa_audit_log.apply_type'] = self::APPLY_TYPE;    // 申请类型条件
            $map['oa_approve.uid'] = $_SESSION['auth_id'];  // 自己的审核结果条件
            $map['oa_audit_log.uid'] = $_SESSION['auth_id'];    // 自己的审核记录条件

            $count = $this->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid  AND __APPROVE__.type = ".self::APPLY_TYPE."  AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->join('LEFT JOIN __AUDIT_LOG__ ON __VENUE__.id = __AUDIT_LOG__.apply_id')
                        ->join('LEFT JOIN oa_user ON oa_venue.uid = oa_user.id')
                        ->join('LEFT JOIN oa_college ON oa_user.cid = oa_college.id')
                        ->count();
            $Page = new \Think\Page($count, 10);
            $rows = $this->page($p, 10)
                        ->where($map)
                        ->join("LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid AND __APPROVE__.type = ".self::APPLY_TYPE."  AND __APPROVE__.uid = {$_SESSION['auth_id']}")
                        ->join('LEFT JOIN __AUDIT_LOG__ ON __VENUE__.id = __AUDIT_LOG__.apply_id')
                        ->join('LEFT JOIN oa_user ON oa_venue.uid = oa_user.id')
                        ->join('LEFT JOIN oa_college ON oa_user.cid = oa_college.id')
                        ->field(array('oa_venue.id', 'oa_venue.code', 'oa_venue.theme', 'oa_approve.time apply_time'))
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
        $apply = $this->where(array('oa_venue.id' => $id))
                    ->field(array('id', 'code', 'uid', 'theme', 'phone', 'proposer', 'num', 'place', 'img', 'planning', 'remark', 'utype', 'stime', 'etime', 'apply_time', 'receiver'))
                    ->find();
        $result = M('Approve')->join('LEFT JOIN __ADMIN__ ON __APPROVE__.uid = __ADMIN__.id')
                            ->join('LEFT JOIN __ROLE__ ON __APPROVE__.role_id = __ROLE__.id')
                            ->where(array('oa_approve.aid' => $id, 'oa_approve.type' => self::APPLY_TYPE))
                            ->field('oa_approve.*,oa_admin.account,oa_role.name role_name')
                            ->select();

        // 是否可以审核
        $myturn = true;
        foreach ($result as $index => $item) {
            // 如果上级拒绝或自己或同样角色的人员审核过就不再审核
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


    /**
     * 审核申请
     * @param  array $data 审核结果
     * @return boolean
     */
    public function audit($data)
    {
        $data['type'] = self::APPLY_TYPE;
        $data['uid'] = session('auth_id');
        $data['time'] = date('Y-m-d H:i:s', time());

        // 判断是否被同角色人员审核
        $map['id'] = array('EQ', $data['aid']);
        $map['role_id'] = array('IN', $_SESSION['role_id']);
        if ($this->where($map)->join('LEFT JOIN __APPROVE__ ON __VENUE__.id = __APPROVE__.aid')->find()) {
            return false;
        }
        // 审核结果入库
        if (M('Approve')->add($data)) {
            $uid = session('auth_id');
            $handle = M('AuditLog')->add(array('apply_id' => $data['aid'], 'uid' => $uid, 'apply_type' => self::APPLY_TYPE)); // 添加到审核日志

            // 如果拒绝就不再转发
            if ($data['isagree'] == 2) {
                return $handle;
            }

            // 转发申请
            $step = C('STEP');
            $index = self::APPLY_TYPE - 1;  // 申请类型

            // 根据申请者类型来转发
            $i = $data['step'] + 1;
            switch ($data['utype']) {
                case 1:
                    $new_receiver = $step[$index][0][$i];
                    break;

                case 2:
                    $new_receiver = $step[$index][1][$i];
                    break;
                
                default:
                    $new_receiver = $step[$index][2][$i];
                    break;
            }
            return $this->save(array('id' => $data['aid'], 'receiver' => $new_receiver));
        }
        return false;
    }



}
